<?php

namespace rainerch\eventhook;

use Bluerhinos\phpMQTT;
use rainerch\eventhook\base\Hook;
use rainerch\eventhook\base\Response;
use yii\helpers\ArrayHelper;

/**
 * Mqtt extends Hook
 *
 * Use this Hook to send Events to a MQTT Service
 *
 * @property string $baseTopic
 * @property string $serverHost
 * @property string $serverPort
 */
class Mqtt extends Hook
{
    public $baseTopic = '/';
    public $serverHost;
    public $serverPort = 1883;
    private $_connection = false;

    /**
     * @param Response $response
     * @param array $data
     * @return bool
     */
    public function handler(Response $response, $data = []): bool
    {
        if ($this->_connection == false) {
            $this->connect();
        }

        $route = str_replace('\\', '/', $response->class);
        $this->_connection->publish($this->baseTopic . '/' . $route, json_encode(ArrayHelper::toArray($response)));

        return true;
    }

    /**
     * Opens the MQTT Connection
     *
     * @return bool
     */
    private function connect()
    {
        $this->_connection = new phpMQTT($this->serverHost, $this->serverPort, uniqid());
        
        if($this->_connection->connect()) {
            return true;
        }

        return false;
    }
}