<?php

use app\models\Book;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model Book */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="book-form-holder">

    <?php $form = ActiveForm::begin([
        'id' => 'book-form',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
            'inputOptions' => ['class' => 'col-lg-3 form-control'],
            'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
        ],
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'year')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea() ?>

    <div class="form-group authors">
        <label class="control-label" for="authors">Authors</label>
        <?php
        try {
            $authorsList = \yii\helpers\ArrayHelper::map($model->authors, 'id', 'fullName');
            echo Select2::widget([
                'id'            => 'authors-list',
                'name'          => 'authors',
                'value'         => array_keys($authorsList),
                'data'          => $authorsList,
                'showToggleAll' => false,
                'theme'         => Select2::THEME_KRAJEE_BS5,
                'options'       => [
                    'placeholder' => 'Choose authors ...',
                    'multiple'    => true
                ],
                'pluginOptions' => [
                    'closeOnSelect'      => false,
                    'allowClear'         => true,
                    'minimumInputLength' => 0,
                    'ajax'               => [
                        'url'      => new JsExpression('function(params) { return getAuthorsUrl() }'),
                        'dataType' => 'json',
                        'data'     => new JsExpression('function(params) { return {q:params.term}; }'),
                        'delay'    => 250,
                    ],
                ],
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();
            Yii::error($e->getMessage());
        }
        ?>

        <div class="help-block"></div>
    </div>
    
    <br/>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <script>
        function getAuthorsUrl() {
            return '<?=Url::to(['/authors/suggest'])?>';
        }
    </script>
</div>
