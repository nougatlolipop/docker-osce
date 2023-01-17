<?php

namespace App\Models;

use CodeIgniter\Model;

class ApiModel extends Model
{
    protected $curl;

    public function __construct()
    {
        $this->curl = service('curlrequest');
    }

    public function getDosen()
    {
        $response = $this->curl->request("GET", getDosen(), [
            "headers" => [
                "Accept" => "application/json"
            ],
        ]);
        return json_decode($response->getBody())->data;
    }

    public function getMahasiswa()
    {
        $response = $this->curl->request("GET", getMahasiswa(), [
            "headers" => [
                "Accept" => "application/json"
            ],

        ]);

        return json_decode($response->getBody())->data;
    }
}
