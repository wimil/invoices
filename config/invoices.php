<?php
//configraciones
return [
    /*
    |--------------------------------------------------------------------------
    | Default Currency
    |--------------------------------------------------------------------------
    |
    | This value is the default currency that is going to be used in invoices.
    | You can change it on each invoice individually.
     */

    'currency' => [
        'code' => 'PEN',
        'symbol' => 'S/.',
        'decimals' => 2,
        'dec_point' => '.',
        'thousands_separator' => ',',
        /**
         * Supported tags {VALUE}, {SYMBOL}, {CODE}
         * Example: 1.99 $
         */
        'format' => '{SYMBOL} {VALUE}',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Invoice Logo
    |--------------------------------------------------------------------------
    |
    | This value is the default invoice logo that is going to be used in invoices.
    | You can change it on each invoice individually.
     */

    'logo' => [
        'url' => 'http://i.imgur.com/t9G3rFM.png',
        'width' => 'auto',
        'height' => 60,
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Invoice From Details
    |--------------------------------------------------------------------------
    |
    | This value is going to be the default attribute displayed in
    | the customer model.
     */

    'from' => [
        'name' => 'My Company',
        'id' => '1234567890',
        'phone' => '+34 123 456 789',
        'location' => 'Main Street 1st',
        'zip' => '08241',
        'city' => 'Barcelona',
        'country' => 'Spain',
    ],

    //default Header Items
    'items_keys' => [
        'id' => 'ID',
        'name' => 'Item Name',
        'price' => 'Price',
        'quantity' => 'Quantity',
        'total' => 'Total',
    ],

    //casts items
    'casts' => [
        'price' => 'currency',
        'total' => 'currency'
    ],

    //key to calculate the subtotal of all items
    'subtotal_by' => 'price',

    /*
    |--------------------------------------------------------------------------
    | Default Invoice Footnote
    |--------------------------------------------------------------------------
    |
    | This value is going to be at the end of the document, sometimes telling you
    | some copyright message or simple legal terms.
     */

    'notes' => '',

    /*
    |--------------------------------------------------------------------------
    | Default Tax Rates
    |--------------------------------------------------------------------------
    |
    | This array group multiple tax rates.
    |
    | The tax type accepted values are: 'percentage' and 'fixed'.
    | The percentage type calculates the tax depending on the invoice price, and
    | the fixed type simply adds a fixed ammount to the total price.
    | You can't mix percentage and fixed tax rates.
     */
    'tax_rates' => [
        [
            'name' => 'IGV',
            'tax' => 18,
            'tax_type' => 'percentage',
        ],
    ],

    //template default
    'template' => 'default',

];
