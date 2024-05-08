<?php

namespace app\models;

use app\interfaces\ISubscriptionsService;
use Throwable;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property string $name
 * @property int $year
 * @property int $amount
 * @property string $isbn
 * @property ?string $description
 * @property ?string $imageUrl
 * 
 * @property-read Author[] $authors
 */
class Book extends ActiveRecord
{
    
    public function rules(): array
    {
        return [
            ['name', 'required'],
            ['year', 'match', 'pattern' => '/^\d{4}$/i'],
            ['amount', 'integer'],
            [['isbn', 'description', 'imageUrl'], 'safe'],
        ];
    }

    public static function tableName(): string
    {
        return '{{%books}}';
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes); 
        
        if(isset($changedAttributes['amount']) && 
            $changedAttributes['amount'] == 0 &&
            $this->amount > 0
        ) {
            try {
                /** @var ISubscriptionsService $notificationService */
                $notificationService = Yii::$container->get(ISubscriptionsService::class);
                $notificationService->sendBookArrivalNotification($this);
            } catch (Throwable $e) {
                Yii::$app->errorHandler->handleException($e);
            }
        }
    }

    /**
     * @throws InvalidConfigException
     */
    public function getAuthors(): ActiveQuery
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])
            ->viaTable('{{%books_authors}}', ['book_id' => 'id']);
    }
}
