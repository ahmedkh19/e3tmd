<?php

namespace App\Http\Controllers\MyFatoorah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SendPayment extends Controller
{

    public function index($postFields)
    {

        /* ------------------------ Configurations ---------------------------------- */
        //Test
        $apiURL = env('fatoorah_base_url');
        $apiKey = env('fatoorah_token');

        //Call endpoint
        $data = $this->sendPayment($apiURL, $apiKey, $postFields);

        return $data->InvoiceURL;
    }


    public function status($id)
    {
        $apiKey = env('fatoorah_token');
        $apiURL = env('fatoorah_base_url');
        $keyId   = $id;
        $KeyType = 'paymentId';

        $postFields = [
            'Key'     => $keyId,
            'KeyType' => $KeyType
        ];
        $json       = $this->callAPI("$apiURL/v2/getPaymentStatus", $apiKey, $postFields);

        $status = $json->Data->InvoiceStatus;
        $amount = $json->Data->InvoiceValue;
        $returnFields = [$status, $amount];
        return $returnFields;

    }


        /* ------------------------ Functions --------------------------------------- */
        /*
         * Send Payment Endpoint Function
         */

        public function sendPayment($apiURL, $apiKey, $postFields) {

            $json = $this->callAPI("$apiURL/v2/SendPayment", $apiKey, $postFields);
            return $json->Data;
        }

    //------------------------------------------------------------------------------
        /*
         * Call API Endpoint Function
         */

        function callAPI($endpointURL, $apiKey, $postFields = [], $requestType = 'POST') {

            $curl = curl_init($endpointURL);
            curl_setopt_array($curl, array(
                CURLOPT_CUSTOMREQUEST  => $requestType,
                CURLOPT_POSTFIELDS     => json_encode($postFields),
                CURLOPT_HTTPHEADER     => array("Authorization: Bearer $apiKey", 'Content-Type: application/json'),
                CURLOPT_RETURNTRANSFER => true,
            ));

            $response = curl_exec($curl);
            $curlErr  = curl_error($curl);

            curl_close($curl);

            if ($curlErr) {
                //Curl is not working in your server
                die("Curl Error: $curlErr");
            }

            $error = $this->handleError($response);
            if ($error) {
                die("Error: $error");
            }

            return json_decode($response);
        }

    //------------------------------------------------------------------------------
        /*
         * Handle Endpoint Errors Function
         */

        function handleError($response) {

            $json = json_decode($response);
            if (isset($json->IsSuccess) && $json->IsSuccess == true) {
                return null;
            }

            //Check for the errors
            if (isset($json->ValidationErrors) || isset($json->FieldsErrors)) {
                $errorsObj = isset($json->ValidationErrors) ? $json->ValidationErrors : $json->FieldsErrors;
                $blogDatas = array_column($errorsObj, 'Error', 'Name');

                $error = implode(', ', array_map(function ($k, $v) {
                    return "$k: $v";
                }, array_keys($blogDatas), array_values($blogDatas)));
            } else if (isset($json->Data->ErrorMessage)) {
                $error = $json->Data->ErrorMessage;
            }

            if (empty($error)) {
                $error = (isset($json->Message)) ? $json->Message : (!empty($response) ? $response : 'API key or API URL is not correct');
            }

            return $error;
        }

        /* -------------------------------------------------------------------------- */
}
