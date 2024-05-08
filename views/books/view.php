<?php

use app\models\Author;
use app\models\Book;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model Book */

$this->title = Yii::$app->name .' - Books - View';
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['/books']];
$this->params['breadcrumbs'][] = $model->name;
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
                'name',
                'year',
                'isbn',
                'description',
                [
                    'label' => 'Authors',
                    'value' => function (Book $book) {
                        $names = array_map(function (Author $author) { return $author->fullName; }, $book->authors);
                        return implode(', ', $names);
                    },
                ],
            ]
        ]);
    } catch (\Throwable $e) {
        Yii::error($e->getMessage());
    } ?>

</div>
