<?php

namespace rainerch\eventhook\base;

use yii\base\BootstrapInterface;
use yii\base\Component;
use yii\base\Event;
use yii\helpers\ArrayHelper;

abstract class Hook extends Component implements BootstrapInterface, HookInterface
{
    public $events = [];

    public final function bootstrap($app)
    {
        foreach($this->events as $event) {
            if(is_string(ArrayHelper::getValue($event, 0))) {
                ArrayHelper::setValue($event, 0, [ArrayHelper::getValue($event, 0)]);
            }

            if(is_string(ArrayHelper::getValue($event, 1))) {
                ArrayHelper::setValue($event, 1, [ArrayHelper::getValue($event, 1)]);
            }

            foreach(ArrayHelper::getValue($event, 0) as $className) {
                foreach(ArrayHelper::getValue($event, 1) as $eventName) {
                    Event::on($className, $eventName, function($e) use ($event) {
                        $response = new Response([
                            'name' => $e->name,
                            'class' => get_class($e->sender),
                            'sender' => $e->sender
                        ]);
                        $this->handler($response, ArrayHelper::getValue($event, 2, []));
                    });
                }
            }
        }
    }
}