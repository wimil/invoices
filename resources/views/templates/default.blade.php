<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $invoice->name }}</title>
    <style>
        * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        span,
        div {
            font-family: DejaVu Sans;

        }

        th,
        td {
            font-family: DejaVu Sans;
            font-size: 12px;
        }

        .panel {
            margin-bottom: 20px;
            background-color: #fff;
            border: 1px solid transparent;
            border-radius: 4px;
            -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
            box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
        }

        .panel-default {
            border-color: #ddd;
        }

        .panel-body {
            padding: 15px;
            font-size: 14px;
        }

        table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 0px;
            border-spacing: 0;
            border-collapse: collapse;
            background-color: transparent;
        }

        thead {
            text-align: left;
            display: table-header-group;
            vertical-align: middle;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px;
        }

        .well {
            min-height: 20px;
            padding: 19px;
            margin-bottom: 20px;
            background-color: #f5f5f5;
            border: 1px solid #e3e3e3;
            border-radius: 4px;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05);
        }
    </style>
</head>

<body>
    <header>
        <div style="position:absolute; left:0pt; width:250pt;">
            <img class="img-rounded" width="{{$invoice->logo->width}}" height="{{$invoice->logo->height}}"
                src="{{ $invoice->logo->url }}">
        </div>
        <div style="margin-left:300pt; font-size: 13px">
            <b>{{ __('invoices::invoice.date') }}: </b> {{ $invoice->date }}<br />
            @if ($invoice->code)
            <b>Invoice: </b> {{ $invoice->code }}
            @endif
            <br />
        </div>
        <br />
        <h2>{{ $invoice->name }}: {{ $invoice->code ? $invoice->code : '' }}</h2>
    </header>
    <main>
        <div style="clear:both; position:relative;">
            <div style="position:absolute; left:0pt; width:250pt;">
                <h4>{{ __('invoices::invoice.to') }}</h4>
                <div class="panel panel-default">
                    <div class="panel-body">
                        {!! $invoice->from->count() == 0 ? '<i>No business details</i><br />' : '' !!}
                        {{ $invoice->from->get('name') }}<br />
                        ID: {{ $invoice->from->get('id') }}<br />
                        {{ $invoice->from->get('phone') }}<br />
                        {{ $invoice->from->get('location') }}<br />
                        {{ $invoice->from->get('zip') }} {{ $invoice->from->get('city') }}
                        {{ $invoice->from->get('country') }}<br />
                    </div>
                </div>
            </div>
            <div style="margin-left: 300pt;">
                <h4>{{ __('invoices::invoice.from') }}</h4>
                <div class="panel panel-default">
                    <div class="panel-body">
                        {!! $invoice->to->count() == 0 ? '<i>No customer details</i><br />' : '' !!}
                        {{ $invoice->to->get('name') }}<br />
                        ID: {{ $invoice->to->get('id') }}<br />
                        {{ $invoice->to->get('phone') }}<br />
                        {{ $invoice->to->get('location') }}<br />
                        {{ $invoice->to->get('zip') }} {{ $invoice->to->get('city') }}
                        {{ $invoice->to->get('country') }}<br />
                    </div>
                </div>
            </div>
        </div>
        <h4>{{ __('invoices::invoice.items') }}:</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    @foreach ($invoice->items_keys as $key)
                    <th>{{$key}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->items as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    @foreach ($item as $key => $value)
                    <td>{{ $item->get($key) }}</td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="clear:both; position:relative;">
            @if($invoice->notes)
            <div style="position:absolute; left:0pt; width:250pt;">
                <h4>{{ __('invoices::invoice.notes') }}:</h4>
                <div class="panel panel-default">
                    <div class="panel-body">
                        {!! is_array($invoice->notes) ? join("<br>", $invoice->notes) : $invoice->notes   !!}
                    </div>
                </div>
            </div>
            @endif
            <div style="margin-left: 300pt;">
                <h4>{{ __('invoices::invoice.total') }}:</h4>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td><b>{{ __('invoices::invoice.subtotal') }}</b></td>
                            <td>{{ $invoice->subtotal() }}</td>
                        </tr>

                        @foreach ($invoice->taxes() as $tax)
                        <tr>
                            <td><b>{{$tax['name']}}</b></td>
                            <td>{{ $tax['tax_total'] }}</td>
                        </tr>
                        @endforeach

                        <tr>
                            <td><b>{{ __('invoices::invoice.total') }}</b></td>
                            <td><b>{{ $invoice->total() }}</b>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @if ($invoice->footnote)
        <br /><br />
        <div class="well">
            {{ $invoice->footnote }}
        </div>
        @endif
    </main>

    <!-- Page count -->
    <script type="text/php">
        if (isset($pdf) && $PAGE_COUNT > 1) {
            $text = "Page {PAGE_NUM} / {PAGE_COUNT}";
            $size = 10;
            $font = $fontMetrics->getFont("DejaVu Sans, Arial, Helvetica, sans-serif", "normal");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width);
            $y = $pdf->get_height() - 35;
            $pdf->page_text($x, $y, $text, $font, $size);
        }
    </script>
</body>

</html>