<?php

namespace app\config\bootstrap;

use app\components\SubscriptionsService;
use app\interfaces\ISubscriptionsService;
use Yii;
use yii\base\BootstrapInterface;

class SubscriptionsServiceBootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        Yii::$container->set(ISubscriptionsService::class, SubscriptionsService::class);
    }
}
