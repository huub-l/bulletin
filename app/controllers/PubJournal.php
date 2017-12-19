<?php

namespace App;

class PubJournal
{
    var $title;
    var $issue;
    var $volume;
    var $year;
    var $start;
    var $end;
    var $nonconsecutive;

    public function __construct () {
        $this->title = 'APN Science Bulletin';
        $this->volume = '7';
        $this->issue = '1';
        $this->year = '2017';
    }

    public function __get($property) {
        if (property_exists($this, $property)) {
        return $this->$property;
        }
    }

    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
        return $this;
    }


}
