<?php

use app\models\Book;

/* @var $this yii\web\View */
/* @var $model Book */

$this->title = Yii::$app->name .' - Authors - Create';
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['/authors']];
$this->params['breadcrumbs'][] = 'Create';
?>
<div class="cities-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
