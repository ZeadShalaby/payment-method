<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class MyFatoorahService
{
    protected $client;
    protected $apiKey;
    protected $countryIso;
    protected $testMode;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = config('myfatoorah.api_key');
        $this->countryIso = config('myfatoorah.country_iso');
        $this->testMode = config('myfatoorah.test_mode');
    }

    public function createInvoice($payload)
    {
        try {
            $url = $this->testMode ? 'https://apitest.myfatoorah.com' : 'https://api.myfatoorah.com';

            $response = $this->client->post("$url/v2/Invoice/Create", [
                'headers' => [
                    'Authorization' => "Bearer {$this->apiKey}",
                    'Content-Type' => 'application/json',
                ],
                'json' => $payload,
            ]);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            // Handle exceptions related to the request
            return ['IsSuccess' => false, 'Message' => $e->getMessage()];
        } catch (\Exception $e) {
            // Handle general exceptions
            return ['IsSuccess' => false, 'Message' => $e->getMessage()];
        }
    }


    public function getPaymentStatus($paymentId)
    {
        try {
            $url = $this->testMode ? 'https://apitest.myfatoorah.com' : 'https://api.myfatoorah.com';

            $response = $this->client->get("$url/v2/Invoice/PaymentStatus", [
                'headers' => [
                    'Authorization' => "Bearer {$this->apiKey}",
                    'Content-Type' => 'application/json',
                ],
                'query' => ['paymentId' => $paymentId],
            ]);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return ['IsSuccess' => false, 'Message' => $e->getMessage()];
        } catch (\Exception $e) {
            return ['IsSuccess' => false, 'Message' => $e->getMessage()];
        }
    }
}
