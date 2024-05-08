<?php

use app\components\RBACAccess;
use app\models\Book;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::$app->name .' - Books';
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['/books']];
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
                    'label' => 'ID',
                    'value' => function(Book $book) {
                        return Html::a($book->id, ['view', 'id' => $book->id]);
                    },
                    'headerOptions' => ['width' => '70'],
                    'contentOptions' => ['style' => 'text-align: right'],
                    'format' => 'raw'
                ],
                [
                    'label' => 'Name',
                    'format' => 'raw',
                    'value' => function(Book $book) {
                        return Html::a($book->name, ['view', 'id' => $book->id]);
                    },
                ],
                'year',
                'isbn'
            ],
        ]);
    } catch (Exception $e) {
        Yii::error($e->getMessage());
    } ?>
</div>
