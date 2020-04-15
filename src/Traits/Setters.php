<?php
namespace Wimil\Invoices\Traits;

/**
 * Invoice Helpers
 */
trait Setters
{
    public function logo($url, $width = 200, $height = 100)
    {
        $this->logo = (object) [
            'url' => $url,
            'width' => $width,
            'height' => $height,
        ];

        return $this;
    }

    public function date($date)
    {
        $this->date = $date;
        return $this;
    }

    public function code($code)
    {
        $this->code = $code;
        $this->filename($this->getDefaultFileName($this->name));
        return $this;
    }

    public function name($name)
    {
        $this->name = $name;
        return $this;
    }

    public function from($array = [])
    {
        $this->form = $this->form->merge($array);
        return $this;
    }

    public function to($array = [])
    {
        //$this->to = $this->to->merge($array)->all();
        $this->to = collect($array);
        return $this;
    }

    public function casts($casts)
    {
        $this->casts = $this->casts->merge($casts)->all();
        return $this;
    }

    public function notes($notes)
    {
        $this->notes = $notes;

        return $this;
    }
}
