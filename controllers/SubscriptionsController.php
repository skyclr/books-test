<?php

namespace app\controllers;

use app\models\Subscription;
use Yii;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

class SubscriptionsController extends BaseWebController
{
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['access']['rules'] = [
            [
                'allow' => true,
            ]
        ];
        
        return $behaviors;
    }

    /**
     * Creates a new Subscription model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($phone, $bookId)
    {
        $model = new Subscription();
        $model->phone = $phone;
        $model->bookId = $bookId;
        $model->save();
        return $model;
    }
    
    /**
     * Deletes an existing Subscription model.
     * If deletion is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionDelete(int $id)
    {
        $model = $this->findModel($id);
        if ($model->delete()) {
            $this->redirect(['index']);
        }

        return $this->redirect(['view', 'id' => $model->id]);
    }
    
    /**
     * Finds the Subscription model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Subscription the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): Subscription
    {
        if (($model = Subscription::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Страница не найдена.');
    }
}
