<?php
namespace Wimil\Invoices;

use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Wimil\Invoices\Traits\CurrencyFormatter;
use Wimil\Invoices\Traits\InvoiceHelpers;
use Wimil\Invoices\Traits\Setters;

class Invoice
{
    use Setters;
    use CurrencyFormatter;
    use InvoiceHelpers;

    public $logo;
    public $date;
    public $code;
    public $name;
    public $from;
    public $to;
    public $items_keys;
    public $items;
    public $notes;
    public $tax_rates;
    public $template;
    public $with_pagination;
    public $filename;
    public $pdf;
    public $output;
    //public $date_format;

    private $casts;
    private $sub_total;
    private $total_taxes;

    public function __construct($name = 'Invoice')
    {
        $this->logo = (object) config('invoices.logo');
        $this->date = Carbon::now()->formatLocalized('%A %d %B %Y');
        //$this->code = $code;
        $this->name = $name;
        $this->from = collect(config('invoices.from'));
        $this->to = collect([]);
        $this->items_keys = collect(config('invoices.items_keys'));
        $this->items = collect([]);
        $this->notes = config('invoices.notes');
        $this->tax_rates = collect(config('invoices.tax_rates'));
        $this->footnote = null;

        $this->filename($this->getDefaultFileName($this->name));
        $this->template = config('invoices.template');

        // Currency
        $this->currency_code = config('invoices.currency.code');
        $this->currency_symbol = config('invoices.currency.symbol');
        $this->currency_decimals = config('invoices.currency.decimals');
        $this->currency_decimal_point = config('invoices.currency.decimal_point');
        $this->currency_thousands_separator = config('invoices.currency.thousands_separator');
        $this->currency_format = config('invoices.currency.format');

        $this->casts = collect(config('invoices.casts'));
        $this->subtotal_by = config('invoices.subtotal_by');
    }

    //construir el invoice
    public static function make($name = 'Invoice')
    {
        return new self($name);
    }

    public function template($template = 'default')
    {
        $this->template = $template;
        return $this;
    }

    public function addItem($item)
    {
        $this->items->push($item);

        return $this;
    }

    public function addItems($items)
    {
        foreach ($items as $item) {
            $this->addItem($item);
        }

        return $this;
    }

    public function subtotal()
    {
        return $this->formatCurrency($this->sub_total);
    }

    public function taxes()
    {
        return $this->tax_rates;
    }

    public function total()
    {
        $total = $this->sub_total + $this->total_taxes;
        return $this->formatCurrency($total);
    }

    public function beforeRender()
    {
        $this->itemsFormatter();
        $this->formatTaxes();
    }

    public function render()
    {
        if (!$this->pdf) {

            $this->beforeRender();

            $template = sprintf('invoices::templates.%s', $this->template);
            $view = View::make($template, ['invoice' => $this]);
            $html = mb_convert_encoding($view, 'HTML-ENTITIES', 'UTF-8');

            $this->pdf = PDF::setOptions(['enable_php' => true, 'isRemoteEnabled' => true])->loadHtml($html);
            $this->output = $this->pdf->output();
        }

        return $this;
    }

    public function save($filename = null, $disk = 'local')
    {
        $this->render();

        $filename = $filename ?? $this->filename;

        Storage::disk($disk)->put($filename, $this->output);

        return $this;
    }

    public function json()
    {
        $this->render();
        return response()->json($this->responseJson(), 200);
    }

    public function show()
    {
        $this->render();

        return new Response($this->output, Response::HTTP_OK, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $this->filename . '"',
        ]);
    }

    public function download()
    {
        $this->render();

        return new Response($this->output, Response::HTTP_OK, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $this->filename . '"',
            'Content-Length' => strlen($this->output),
        ]);
    }
}
