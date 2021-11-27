<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $data
 * @property string $html
 */
class ForecastDetailRecord extends ActiveRecord
{
    public static function primaryKey()
    {
        return ['id'];
    }

    public static function tableName()
    {
        return '{{%forecast_detail}}';
    }

    public function attributes()
    {
        return ['id', 'data', 'html'];
    }

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['data', 'html'], 'safe'],
        ];
    }
}