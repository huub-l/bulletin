<?php

namespace App\Controllers;

class Contributor
{
    public $function;
    public $first;
    public $last;

    public function __construct($function = 'author')
    {
        $this->function = $function;
        $this->first = 'John';
        $this->last = 'Doe';
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }

        return $this;
    }

    public function setFirst($display_name)
    {
        $name_array = explode(' ', $display_name);
        array_pop($name_array);

        $this->first = ucfirst(strtolower(implode(' ', $name_array)));
    }

    public function setLast($display_name)
    {
        $name_array = explode(' ', $display_name);

        $this->last = ucfirst(strtolower(end($name_array)));
    }
}
