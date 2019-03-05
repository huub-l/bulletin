<?php

namespace App\Controllers;

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
    public $email;

    public function __construct($title = 'Title missing', $doi = '')
    {
        $this->key = '99bfaab36cf64c5d9dc86f79520acabe';
        $this->source = 'journal';
        $this->style = 'apa';
        $this->pubtype = 'pubjournal';
        $this->issn = '2522-7971';
        $this->title = $title;
        $this->doi = $doi;
        $this->email = getenv('CROSSREF_EMAIL')
               ? getenv('CROSSREF_EMAIL')
               : 'apnwebmaster@apn-gcr.org';
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

    /**
     * Get Formatted Citation from CrossRef API.
     *
     * @return string $result
     */
    public function getFormattedCitation($doi = null)
    {
        // Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/

        $headers[] = 'Accept: text/x-bibliography; locale=en-GB; style='.$this->style;
        $url = $doi ? $doi : $this->doi;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://doi.org/'.$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        //curl_setopt($ch, CURLOPT_TIMEOUT, 5);

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            return false;
        }

        curl_close($ch);

        return $result;
    }

    /**
     * Get Cited by XML Result from CrossRef API.
     *
     * @return object SimpleXMLEliment
     */
    public function getCitedByXml($doi = null)
    {
        $doi = $doi ? $doi : $this->doi;
        $batchId = time();
        $email = $this->email;

        $xmlData = <<<EOT
<?xml version = "1.0" encoding="UTF-8"?>
<query_batch version="2.0" xmlns = "http://www.crossref.org/qschema/2.0"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xsi:schemaLocation="http://www.crossref.org/qschema/2.0 http://www.crossref.org/qschema/crossref_query_input2.0.xsd">
<head>
    <email_address>{$email}</email_address>
    <doi_batch_id>{$batchId}</doi_batch_id>
</head>
<body>
    <fl_query alert="true">
      <doi>{$doi}</doi>
    </fl_query>
</body>
</query_batch>
EOT;

        $queryUrl = 'https://doi.crossref.org/servlet/query?usr='
        .getenv('CROSSREF_USER').'&pwd='
        .getenv('CROSSREF_PASSWORD').'&format=unixref&qdata='
        .urlencode($xmlData);

        $xml = simplexml_load_string(file_get_contents($queryUrl));

        if ($xml !== false) {
            $xml->registerXPathNamespace('x', 'http://www.crossref.org/qrschema/2.0');
            return $xml;
        }
    }

    /**
     * Get Cited by Count from CrossRef API.
     *
     * @return string
     */
    public function retrieveCitedByCount($doi = null)
    {
        $doi = $doi ? $doi : $this->doi;
        $metadata = $this->getCrossRefMetadata($doi);
        $metaJson = json_decode($metadata, true);

        if ($metadata) {
            $hasCitedBy = strpos($metadata, 'is-referenced-by-count') > 0 ? true : false;
        } else {
            $hasCitedBy = false;
        }

        $count = $hasCitedBy ? $metaJson['message']['is-referenced-by-count'] : 0;

        return $count;
    }

    /**
     * Get Cited by Count from CrossRef API.
     *
     * @return string
     */
    public function getCrossRefMetadata($doi = null)
    {
        $doi = $doi ? $doi : $this->doi;
        $queryUrl = 'https://api.crossref.org/works/'.$doi.'?mailto='.$this->email;
        $content = @file_get_contents($queryUrl);
        if ($content) {
            return $content;
        }
    }
}
