<?php

/* @var $this yii\web\View */
/* @var $model app\modules\nsi\models\Cities */

$this->title = Yii::$app->name .' - Books - Create';
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['/books']];
$this->params['breadcrumbs'][] = 'Edit';

?>
<div class="cities-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
