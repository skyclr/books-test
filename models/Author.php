<?php

namespace app\models;

use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property string $firstname
 * @property string $lastname
 * @property string $middlename
 * 
 * @property-read Book[] $books
 * @property-read string fullName
 */
class Author extends ActiveRecord
{
    public function rules()
    {
        return [
            ['firstname', 'required'],  
            [['lastname', 'middlename'], 'required'],  
        ];
    }

    public static function tableName(): string
    {
        return '{{%authors}}'; 
    }

    /**
     * @throws InvalidConfigException
     */
    public function getBooks(): ActiveQuery
    {
        return $this->hasMany(Book::class, ['id' => 'book_id'])
            ->viaTable('{{%books_authors}}', ['author_id' => 'id']);
    }

    /**
     * Returns full name of author
     * @return string
     */
    public function getFullName(): string
    {
        return trim(implode(' ', [
            $this->firstname ?? '',
            $this->lastname ?? '',
            $this->middlename ?? '',
        ]));
    }
}
