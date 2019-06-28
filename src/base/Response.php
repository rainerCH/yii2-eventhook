<?php

namespace rainerch\eventhook\base;

use yii\base\Model;

/**
 * Base Response Model
 *
 * @property string $name Name of the Event, e.g. afterUpdate
 * @property string $class Name of the Event Class
 * @property object $sender Object of the Sender Event Class
 */
class Response extends Model
{
    public $name;
    public $class;
    public $sender;

    public function fields()
    {
        return ['name', 'class', 'sender'];
    }

}