<?php

namespace App\Http\Traits;
use Illuminate\Http\Request;
use Salman\Mqtt\MqttClass\Mqtt;

trait MqttTrait{

    public function mqttPublish($topic, $command)
    {
        $mqtt_published     =   (new Mqtt())->ConnectAndPublish($topic, $command);
        return $mqtt_published;
    }


}