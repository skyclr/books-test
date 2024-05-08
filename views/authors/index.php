<?php

use app\components\RBACAccess;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::$app->name .' - Authors';
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['/authors']];
$this->params['breadcrumbs'][] = 'List';
?>
<div>

    <p>
        <?php
        if(!Yii::$app->user->isGuest) {
            echo Html::a('Добавить', ['create'], ['class' => 'btn btn-success']);
        }
        ?>
    </p>

    <?php try {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'attribute' => 'id',
                    'headerOptions' => ['width' => '70'],
                    'contentOptions' => ['style' => 'text-align: right'],
                    'format' => 'raw'
                ],
                [
                        'label' => 'Name',
                        'format' => 'raw',
                        'value' => function(\app\models\Author $model)
                        {
                            return Html::a($model->fullName, ['view', 'id' => $model->id]);
                        }
                ],
            ],
        ]);
    } catch (Exception $e) {
        Yii::error($e->getMessage());
    } ?>
</div>
