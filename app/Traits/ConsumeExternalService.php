<?php

namespace App\Traits;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Log;

trait ConsumeExternalService
{
    /**
     * Send request to any service
     * @param $method
     * @param $requestUrl
     * @param array $formParams
     * @param array $headers
     * @return string
     */
    public function performRequest($method, $requestUrl, $data, $headers = [])
    {
        $client = new Client();

        $headers["Content-Type"] = "application/json";
        $headers["Accept"] = "application/json";

        try {

            $response = $client->request($method, $requestUrl, [
                'headers'     => $headers,
                'body' => $data,
            ]);

            return $response->getBody()->getContents();
        } catch (ClientException $e) {
            $response = $e->getResponse();
            return $response->getBody()->getContents();
        }
    }


    public function performRequestFormData($method, $requestUrl, $data, $headers = [])
    {
        try {
            $response = Http::withHeaders($headers)
                ->retry(3, 100, function (Exception $exception, PendingRequest $request) {
                    return $exception instanceof ConnectionException;
                })
                ->$method($requestUrl, $data);

            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            return json_decode($e->response->getBody()->getContents());
        } catch (ConnectionException $e) {
            return (object)[
                'message' => 'Gagal terhubung ke server. Periksa koneksi atau coba lagi nanti.',
            ];
        }
    }




    // public function performRequestFormData($method, $requestUrl, $data, $headers = [])
    // {
    //     $client = new Client();

    //     try {
    //         $response = $client->request($method, $requestUrl, [
    //             'headers'     => $headers,
    //             'form_params' => $data
    //         ]);

    //         return $response->getBody()->getContents();
    //     } catch (ClientException $e) {
    //         $response = $e->getResponse();
    //         return $response->getBody()->getContents();
    //     } catch (ConnectException $e) {
    //         return json_encode([
    //             'error' => 'Gagal terhubung ke server. Periksa koneksi atau coba lagi nanti.',
    //         ]);
    //     }
    // }


    public function performRequestWithFile($method, $requestUrl, $request, $headers = [])
    {
        $client = new Client();

        $headers["Accept"] = "application/json";

        $name = $request->file('file')->getClientOriginalName();
        $path = base_path() . "/public/uploads/";
        $request->file->move($path, $name);

        try {

            $response = $client->request($method, $requestUrl, [
                'headers'     => $headers,
                'multipart' => [
                    [
                        'name'     => 'file',
                        'contents' => fopen($path . $name, "r"),
                        'filename' => $name
                    ]
                ],
            ]);

            return $response->getBody()->getContents();
        } catch (ClientException $e) {
            $response = $e->getResponse();
            return $response->getBody()->getContents();
        }
    }
}
