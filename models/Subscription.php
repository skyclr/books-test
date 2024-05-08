<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property string $phone
 * @property int $bookId
 * 
 * @property-read Book $book
 */
class Subscription extends ActiveRecord
{
    
    public function rules(): array
    {
        return [
            [['phone', 'bookId'], 'required']
        ];
    }

    public static function tableName(): string
    {
        return '{{%subscriptions}}';
    }
    
    public function getBook(): ActiveQuery
    {
        return $this->hasMany(Book::class, ['id' => 'bookId']);
    }
}
