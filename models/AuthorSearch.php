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
}
