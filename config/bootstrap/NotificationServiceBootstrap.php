<?php

namespace common\config\bootstrap;

use app\interfaces\INotificationService;
use SmsPilotNotificationService;
use Yii;
use yii\base\BootstrapInterface;

class NotificationServiceBootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        Yii::$container->set(INotificationService::class, [
            'class' => SmsPilotNotificationService::class
        ], [
            'url'     => getenv('SMSPILOT_URL'),
            'apiKey' => getenv('SMSPILOT_APIKEY')
        ]);
    }
}
