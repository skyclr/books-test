<?php

namespace app\models;

class AuthorSearch extends Author
{
    public static function findByName(string $q, int $limit = 10): array
    {
        return static::find()
            ->where([
                'OR',
                ['like', 'firstname', $q],
                ['like', 'lastname', $q],
                ['like', 'middlename', $q],
            ])
            ->limit($limit)
            ->all();
    }

    public static function getTopByYear(int $year): \yii\db\ActiveQuery
    {
        return static::find()
            ->select([Author::tableName().'.*', 'booksCount' => 'COUNT(' . Book::tableName() .'.id)'])
            ->joinWith('books')
            ->where([Book::tableName() . '.year' => $year])
            ->groupBy(Author::tableName() . '.id')
            ->orderBy(['COUNT(' . Book::tableName() .'.id)' => SORT_DESC])
            ->asArray();
    }
}
