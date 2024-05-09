<?php

namespace app\models;

use yii\base\Model;

class TopAuthorsForm extends Model
{
    public string $year;
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['year', 'match', 'pattern' => '/^\d{4}$/i'],
        ];
    }
    
    public function init()
    {
        parent::init();
        $this->year = date('Y');
    }
}
