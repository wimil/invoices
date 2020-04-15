## What is Invoices?

Invoices is a Laravel library that generates a PDF invoice for your customers. The PDF can be either downloaded or
streamed in the browser. It's highly customizable and you can modify the whole output view as well.

## Install
```bahs
composer require wimil/invoices
```
## Publish

### Config
```bash
php artisan vendor:publish --tag=invoices.config
```

### Views
```bash
php artisan vendor:publish --tag=invoices.views
```

### Translations
```bash
php artisan vendor:publish --tag=invoices.translations
```


```php
$invoice = \Wimil\Invoices\Invoice::make()
            ->code('PA-0001')
            ->name('Invoice')
            ->to([
                'name' => 'Èrik Campobadal Forés',
                'id' => '12345678A',
                'phone' => '+34 123 456 789',
                'location' => 'C / Unknown Street 1st',
                'zip' => '08241',
                'city' => 'Manresa',
                'country' => 'Spain',
            ])
            ->addItem([10, 'Test Item', 200.50, 1, 200.50])
            ->addItem([11, 'Test Item', 500.00, 2, 1000.00])
            ->save()
            ->show();
```
