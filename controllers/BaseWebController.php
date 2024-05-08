<?php

namespace app\controllers;

use app\components\RBACAccess;
use yii\filters\AccessControl;
use yii\web\Controller;

class BaseWebController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                    ],
                ],
            ],
        ] + parent::behaviors();
    }
}
