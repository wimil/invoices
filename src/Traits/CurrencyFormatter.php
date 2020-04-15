<?php

namespace Wimil\Invoices\Traits;

/**
 * Trait CurrencyFormatter
 */
trait CurrencyFormatter
{
    /**
     * @var string
     */
    public $currency_code;

    /**
     * @var string
     */
    public $currency_symbol;

    /**
     * @var int
     */
    public $currency_decimals;

    /**
     * @var string
     */
    public $currency_decimal_point;

    /**
     * @var string
     */
    public $currency_thousands_separator;

    /**
     * @var string
     */
    public $currency_format;

    /**
     * @param string $code
     * @return $this
     */
    public function currencyCode(string $code)
    {
        $this->currency_code = $code;

        return $this;
    }


    /**
     * @param string $symbol
     * @return $this
     */
    public function currencySymbol(string $symbol)
    {
        $this->currency_symbol = $symbol;

        return $this;
    }

    /**
     * @param int $decimals
     * @return $this
     */
    public function currencyDecimals(int $decimals)
    {
        $this->currency_decimals = $decimals;

        return $this;
    }

    /**
     * @param string $decimal_point
     * @return $this
     */
    public function currencyDecimalPoint(string $decimal_point)
    {
        $this->currency_decimal_point = $decimal_point;

        return $this;
    }

    /**
     * @param string $thousands_separator
     * @return $this
     */
    public function currencyThousandsSeparator(string $thousands_separator)
    {
        $this->currency_thousands_separator = $thousands_separator;

        return $this;
    }

    /**
     * @param string $format
     * @return $this
     */
    public function currencyFormat(string $format)
    {
        $this->currency_format = $format;

        return $this;
    }

    /**
     * @param float $amount
     * @return string
     */
    public function formatCurrency($amount)
    {
        $value = number_format(
            $amount,
            $this->currency_decimals,
            $this->currency_decimal_point,
            $this->currency_thousands_separator
        );

        return strtr($this->currency_format, [
            '{VALUE}' => $value,
            '{SYMBOL}' => $this->currency_symbol,
            '{CODE}' => $this->currency_code,
        ]);
    }
}
