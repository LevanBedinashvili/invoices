<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class SmsController extends Controller
{
    public function sendSms()
    {
        $apiKey = '53d19f42-042f-4cfe-80a1-970d785e8d96';
        $url = 'https://sms-api.wifisher.com/api/v2/send';

        $postData = [
            'from' => 'iPlus.ge',
            'to' => '995557656494',
            'content' => 'დემეტრე, დააბრუნე თიბისის ვალები და მიიღე iphone 15 pro max საჩუქრად !!',
        ];

        $queryString = http_build_query(array_merge($postData, ['api-key' => $apiKey]));

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url . '?' . $queryString,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        echo $response;
    }

    public function getBalance()
    {
        $apiKey = '53d19f42-042f-4cfe-80a1-970d785e8d96'; // Replace with your actual API key
        $url = 'https://sms-api.wifisher.com/api/v2/balance';

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'api-key: ' . $apiKey,
            ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        echo $response;
    }

    public function getPersonStatus(Request $request)
    {
        // Replace 'YOUR_API_KEY' with your actual API key
        $apiKey = 'AIzaSyDsHQIw7TJn_e5tT5FhfCfnICHK69apZJE';
        // Replace 'YOUR_PERSONAL_NUMBER' with the actual personal number you want to pass
        $personalNumber = '59901132123';

        // API endpoint
        $apiEndpoint = 'https://eapi.rs.ge/Gambling/GetPersonStatus';

        // Prepare data
        $data = [
            'pnumber' => $personalNumber,
            // Add other parameters if needed
        ];

        // Initialize cURL session
        $ch = curl_init($apiEndpoint);

        // Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json',
        ]);

        // Execute cURL session
        $response = curl_exec($ch);

        // Close cURL session
        curl_close($ch);

        // Decode the JSON response
        $responseData = json_decode($response, true);

        // Handle the response as needed
        // $responseData contains the data returned from the API

        return response()->json($responseData);
    }
}

