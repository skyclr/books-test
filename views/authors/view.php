<?php

use app\models\Author;
use app\models\Book;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model Author */

$this->title = Yii::$app->name .' - Authors - View';
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['/authors']];
$this->params['breadcrumbs'][] = $model->fullName;
?>
<div class="cities-view">

    <p>
        <?php
        if(!Yii::$app->user->isGuest) {
            echo Html::a('Edit', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']).' ';
        }
        ?>
    </p>

    <?php try {
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'firstname',
                'lastname',
                'middlename',
            ]
        ]);
    } catch (\Throwable $e) {
        echo $e->getMessage();
        Yii::error($e->getMessage());
    } ?>

</div>
