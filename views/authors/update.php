<?php

/* @var $this yii\web\View */
/* @var $model app\modules\nsi\models\Cities */

$this->title = Yii::$app->name .' - Authors - Update';
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['/authors']];
$this->params['breadcrumbs'][] = 'Edit';

?>
<div class="cities-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
