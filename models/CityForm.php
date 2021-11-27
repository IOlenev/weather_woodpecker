<?php

namespace app\models;

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
            [['name'], 'unique', 'targetClass' => 'app\models\CityRecord'],
            [['name'], 'filter', 'filter' => function($value) {
                    return trim(preg_replace('`[\s]{1,}`', ' ',
                        preg_replace('`[0-9]`', '', $value)));
            } ],
        ];
    }

    public function save()
    {
        $result = false;
        if ($this->validate()) {
            $city = new CityRecord();
            $city->name = $this->name;
            $result = $city->save();
        }

        if ($result) {
            $result = $city->primaryKey;
        }
        return $result;
    }
}
