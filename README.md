# yii2-eventhook
Forward yii2 events to different targets (Web, MQTT ...)

## How to use

In your config.php:

```php
<?php
$config = [
    'bootstrap' = ['webhook'],
    'components' = [
        'webook' => [
            'class' => 'rainerch\eventhook\HttpPost',
            'events' => [
                [['\yii\db\ActiveRecord'], ['afterInsert', 'afterUpdate'], [
                    'url' => 'https://example.com/myAwesomeWebhook'
                ]],
                ['app\MyModel', 'afterInsert', [
                    'url' => 'https://example.com/MyAwesomeModelWebhook'
                ]]
            ]
        ],
    ]
]
```
