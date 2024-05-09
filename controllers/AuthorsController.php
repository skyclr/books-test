<?php

namespace app\controllers;

use app\models\Author;
use app\models\AuthorSearch;
use app\models\TopAuthorsForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class AuthorsController extends BaseWebController
{
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['access']['rules'] = [
            [
                'allow' => false,
                'actions' => ['create', 'delete', 'update'],
                'roles' => ['?'],
            ],
            [
                'allow' => true,
            ]
        ];
        
        return $behaviors;
    }

    public function actionIndex(): string
    {
        return $this->render('index', [
           'dataProvider' => new ActiveDataProvider([
               'query' => Author::find()
           ]) 
        ]);
    }


    /**
     * Displays a single Author model.
     * @param integer $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id): string
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Author model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Author();
        $data = Yii::$app->request->post();

        if ($model->load($data) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Author model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be foun
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Author model.
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
     * Finds the Author model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Author the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): Author
    {
        if (($model = Author::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Страница не найдена.');
    }

    /**
     * Retrieves authors list for suggest helper
     * @param string $q Search query
     * @return array|Response
     */
    public function actionSuggest(string $q)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        if(!$q) {
            return [];
        }
        
        $authors = AuthorSearch::findByName($q);
          
        return $this->asJson(['results' => array_map(function(Author $author) {
            return [
                'id' => $author->id,
                'text' => $author->fullName,
            ];
        }, $authors)]);
    }
    
    public function actionTop(): string
    {
        $model = new TopAuthorsForm();
        $model->load(Yii::$app->request->post());
        
        return $this->render('top', [
            'dataProvider' => new ActiveDataProvider([
                'query' => AuthorSearch::getTopByYear($model->year)
            ]),
            'model' => $model
        ]);
    }
}
