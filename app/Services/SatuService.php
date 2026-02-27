<?php

namespace App\Services;

use App\Traits\ConsumeExternalService;

class SatuService
{
    use ConsumeExternalService;

    /**
     * The base uri to consume authors service
     * @var string
     */
    public $baseUri;

    /**
     * Authorization secret to pass to author api
     * @var string
     */
    public $secret;

    public function __construct()
    {
        $this->baseUri = "https://gateway.telkomuniversity.ac.id";
    }

    public function login($data)
    {
        return $this->performRequestFormData('POST', $this->baseUri.'/issueauth', $data, []);
    }

    public function profile($data)
    {
        return $this->performRequestFormData('GET', $this->baseUri.'/issueprofile', [], ['Authorization'=>'Bearer '.$data]);
    }

}
