<?php

namespace App;

class Contributor
{
    public $function;
    public $first;
    public $middle;
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
}
