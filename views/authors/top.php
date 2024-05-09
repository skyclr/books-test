<?php

use app\models\TopAuthorsForm;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/** @var $model TopAuthorsForm */

$this->title = Yii::$app->name .' - Authors';
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['/authors']];
$this->params['breadcrumbs'][] = 'Top';
?>
<div>

    <div>
        <?php

        $form = ActiveForm::begin([
            'layout' => 'horizontal',
            'class' => 'form-horizontal',
        ]);
        
        ?>
        <div class="row">
            <div class="col-sm-2">
                <?= $form->field($model, 'year')->textInput();?>
            </div>
            <div class="col-sm-6">
                <?= Html::submitButton('Update', ['class' => 'btn btn-primary'])?>
            </div>
        </div>
        
        <?php 
        
        ActiveForm::end();
        
        ?>
    </div>

    <?php try {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'attribute' => 'id',
                    'headerOptions' => ['width' => '70'],
                    'contentOptions' => ['style' => 'text-align: right'],
                    'format' => 'raw',
                    'enableSorting' => false
                ],
                [
                    'label' => 'Name',
                    'format' => 'raw',
                    'value' => function(array $data)
                    {
                        return $data['firstname'];
                    }
                ],
                [
                    'label' => 'Books count',
                    'attribute' => 'booksCount'
                ],
            ],
        ]);
    } catch (Exception $e) {
        echo $e->getMessage();
        Yii::error($e->getMessage());
    } ?>
</div>
