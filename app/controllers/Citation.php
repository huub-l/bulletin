<?php

namespace App;

use Sober\Controller\Controller;

class Citation extends Controller
{
    public $key;
    public $source;
    public $style;
    public $title;
    public $pubtype;
    public $pubjournal;
    public $contributors;
    public $issn;
    public $doi;

    public function __construct($title = 'Title missing', $doi = '')
    {
        $this->key = '99bfaab36cf64c5d9dc86f79520acabe';
        $this->source = 'journal';
        $this->style = 'apa';
        $this->pubtype = 'pubjournal';
        $this->issn = '2522-7971';
        $this->title = $title;
        $this->doi = $doi;
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

    /**
     * @param $pubjournal Object
     * @param $contributors Object
     */
    public function getBib($pubjournal, $contributors)
    {
        $this->pubjournal = $pubjournal;
        $this->contributors = $contributors;

        $data = json_encode([
            'key'     => $this->key,
            'source'  => $this->source,
            'style'   => $this->style,
            'journal' => [
                'title' => $this->title,
            ],
            'pubtype' => [
                'main' => $this->pubtype,
            ],
            'contributors' => $this->contributors,
            'pubjournal'   => $this->pubjournal,
            'issn'         => $this->issn,
            'doi'          => [
                'doi' => $this->doi,
            ],
        ]);

        $result = $this->callAPI('POST', 'https://api.citation-api.com/2.1/rest/cite', $data);

        $result = json_decode($result);

        if ($result->status == 'ok') {
            return $result->data;
        } else {
            return 'ERROR';
        }
    }

    private function callAPI($method, $url, $data = false)
    {
        // Courtesy of Christoph Winkler
        // https://stackoverflow.com/questions/9802788/call-a-rest-api-in-php

        $curl = curl_init();

        switch ($method) {
            case 'POST':
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                break;
            case 'PUT':
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data) {
                    $url = sprintf('%s?%s', $url, http_build_query($data));
                }
        }

        // Optional Authentication:
        // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }
}
