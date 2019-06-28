<?php

namespace rainerch\eventhook;

use rainerch\eventhook\base\Hook;
use rainerch\eventhook\base\Response;
use yii\helpers\ArrayHelper;

/**
 * HttpPost extends Hook for HTTP-Post Calls
 *
 * Use this Hook to make Simple Post-Calls to any HTTP Interface
 *
 * @property int $timeout_connection Curl Timeout of Connection
 * @property int $timeout_response Curl Timeout of Response
 */
class HttpPost extends Hook
{
    public $timeout_connection = 0;
    public $timeout_response = 0;

    /**
     * @param Response $response
     * @param array $data Should contain an `url` Key with the HTTP-URL as value
     * @return bool
     */
    public function handler(Response $response, $data = []): bool
    {
        $url = ArrayHelper::getValue($data, 'url', false);

        if(!$url) {
            return false;
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(ArrayHelper::toArray($response)));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->timeout_connection);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout_response);
        curl_exec($ch);
        curl_close($ch);

        return true;
    }
}