<?php
namespace App\Services;

use App\Models\SmsLog;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SmsService
{
    protected $apiUrl = 'http://bi.msg.ge/sendsms.php';
    protected $username = 'iphoneplus';
    protected $password = 'ViCcPC5TeT';
    protected $client_id = 1110;
    protected $service_id = 3031;

    public function send($phone, $text, $warrantyId = null)
    {
        $params = [
            'to' => $phone,
            'text' => $text,
            'service_id' => $this->service_id,
            'client_id' => $this->client_id,
            'password' => $this->password,
            'username' => $this->username,
            'utf' => 1,
            'result' => 'json',
        ];
        $query = http_build_query($params);
        $url = $this->apiUrl . '?' . $query;
        $msgHeader = env('SMS_MSG_HEADER', null); // set in .env if needed
        if ($msgHeader) {
            $opts = [
                'http' => [
                    'method' => "GET",
                    'header' => "MSG_HEADER: $msgHeader"
                ]
            ];
            $context = stream_context_create($opts);
            $response = file_get_contents($url, false, $context);
        } else {
            $response = file_get_contents($url);
        }
        $jsonResponse = json_decode($response, true);
        $status = ($jsonResponse['code'] ?? '') === '0000' ? 'sent' : 'failed';
        SmsLog::create([
            'warranty_id' => $warrantyId,
            'to' => $phone,
            'text' => $text,
            'status' => $status,
            'response' => $response,
            'sent_at' => Carbon::now(),
            'sent_by' => Auth::id(),
        ]);
        dd([
            'url' => $url,
            'params' => $params,
            'json_response' => $jsonResponse,
            'status' => $status,
            'msg_header' => $msgHeader,
        ]);
    }
}
