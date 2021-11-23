<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * City form validation
 */
class CityForm extends Model
{
    public $name;

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'filter', 'filter' => function($value) {
                    return trim(preg_replace('`[\s]{1,}`', ' ',
                        preg_replace('`[0-9]`', '', $value)));
            } ],
        ];
    }
}
