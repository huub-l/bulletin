<?php

namespace App;

class PubJournal
{
    public $title;
    public $issue;
    public $volume;
    public $year;
    public $start;
    public $end;
    public $nonconsecutive;

    public function __construct()
    {
        $this->title = 'APN Science Bulletin';
        $this->volume = '9';
        $this->issue = '9';
        $this->year = '9999';
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
