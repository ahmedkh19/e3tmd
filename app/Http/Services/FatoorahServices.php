<?php


namespace App\Http\Services;


use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class FatoorahServices
{

    private $base_url;
    private $headers;
    private $request_client;

    /*
     * FatoorahService constructor
     * @param Client $request_client
     */
    public function __construct(Client $request_client)
    {
        $this->request_client = $request_client;
        $this->base_url = config('fatoorah.fatoorah_base_url');
        $this->headers = [
            'Content-Type' => 'application/json',
            'authorization' => 'Bearer ' . config('fatoorah.fatoorah.token')
        ];
    }
    /*
     * @param $uri
     * @param $method
     * @param array $body
     * @return false|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function buildRequest($uri, $method, $body = [])
    {
        $request = new Request($method, $this->base_url, $uri, $this->headers);
        if (!$body)
            return false;

        $response = $this->request_client->send($request, [
            'json' => $body
        ]);

        if ($response->getStatusCode() != 200 )
            return false;

        $response = json_decode($response->getBody(), true);
        return $response;

    }

    public function sendPayment($paitient_id, $fee, $plan_id, $subscriptionPlan)
    {
        $requestData = $this->parsePaymentData();
        $response = $this->buildRequest('v2/SendPayment', 'POST', $requestData);

        if ($response) {
            //SAVE TRANSACTION
        }

        return $response;
    }
}