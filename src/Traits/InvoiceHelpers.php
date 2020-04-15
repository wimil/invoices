<?php
namespace Wimil\Invoices\Traits;

use Illuminate\Support\Str;
/**
 * Invoice Helpers
 */
trait InvoiceHelpers
{
    private function itemsFormatter()
    {
        //we combine the keys with the values of the items
        $this->combineItemsWithKeys();

        $newItems = [];
        foreach ($this->items as $item) {
            $this->sub_total += $item[$this->subtotal_by];
            foreach ($item as $key => $value) {
                if ($this->casts->get($key) == 'currency') {
                    $item[$key] = $this->formatCurrency($value);
                }
            }

            $newItems[] = $item;
        }

        $this->items = collect($newItems);

    }

    private function combineItemsWithKeys()
    {

        $keys = $this->items_keys->keys();

        $items = $this->items->map(function ($item) use ($keys) {
            return $keys->combine($item);
        });

        $this->items = $items;

    }

    

    private function getDefaultFileName($name)
    {
        if ($name === '') {
            return sprintf('%s', $this->code);
        }

        return sprintf('%s_%s', Str::snake($name), $this->code);
    }

    /**
     * @param string $filename
     * @return $this
     */
    public function filename($filename)
    {
        $this->filename = sprintf('%s.pdf', $filename);

        return $this;
    }

    private function formatTaxes()
    {
        $taxes = [];
        foreach ($this->tax_rates as $taxe) {
            if ($taxe['tax_type'] == 'percentage') {
                $taxe['tax_total'] = bcdiv(bcmul($taxe['tax'], $this->sub_total, $this->currency_decimals), 100, $this->currency_decimals);
            } else {
                $taxe['tax_total'] = $taxe['tax'];
            }

            $this->total_taxes += $taxe['tax_total'];
            $taxe['tax_total'] = $this->formatCurrency($taxe['tax_total']);

            $taxes[] = $taxe;
        }

        $this->tax_rates = collect($taxes);
    }

    private function responseJson()
    {
        $response = [
            'logo' => $this->logo,
            'date' => $this->date,
            'code' => $this->code,
            'name' => $this->name,
            'from' => $this->from,
            'to' => $this->to,
            'items_keys' => $this->items_keys,
            'items' => $this->items,
            'notes' => $this->notes,
        ];

        $response['subtotal'] = $this->subtotal();
        $response['taxes'] = $this->taxes();
        $response['total'] = $this->total();

        /*$response['invoice'] = [
            'show' => null,
            "download" => null,
        ];*/

        return $response;
    }
}
