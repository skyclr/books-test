<?php

namespace app\controllers;

use app\models\Author;
use app\models\Book;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class BooksController extends BaseWebController
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
               'query' => Book::find()
           ]) 
        ]);
    }


    /**
     * Displays a single Book model.
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
     * Creates a new Book model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Book();
        
        if(Yii::$app->request->isPost)
        {
            $data = Yii::$app->request->post();
            $transaction = Yii::$app->db->beginTransaction();

            try {
                if ($model->load($data) && $model->save()) {
                    $this->updateBookAuthors($model, $data);
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }

                $transaction->rollBack();
            } catch (\Throwable $e) {
                $transaction->rollBack();
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Book model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be foun
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);
        
        if(Yii::$app->request->isPost) 
        {
            $data = Yii::$app->request->post();
            $transaction = Yii::$app->db->beginTransaction();

            try {
                if ($model->load($data) && $model->save()) {
                    $this->updateBookAuthors($model, $data);
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                
                $transaction->rollBack();
            } catch (\Throwable $e) {
                $transaction->rollBack();
                die($e->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Book model.
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
        
        }

        return $this->redirect(['view', 'id' => $model->id]);
    }
    
    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): Book
    {
        if (($model = Book::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Страница не найдена.');
    }
    
    private function updateBookAuthors(Book $model, $data)
    {
        if(!isset($data['authors']) || !is_array($data['authors'])) {
            return;
        }

        $bookAuthors = $model->authors;
        $bookAuthorsIds = ArrayHelper::getColumn($bookAuthors,'id');
        
        foreach ($data['authors'] as $authorId) {
            if(!in_array($authorId, $bookAuthorsIds)) {
                $author = Author::findOne($authorId);
                if($author) {
                    $model->link('authors', $author);
                }
            }
        }
        
        foreach($bookAuthors as $author) {
            if(!in_array($author->id, $data['authors'])) {
                $model->unlink('authors', $author, true);
            }
        }
    }
}
