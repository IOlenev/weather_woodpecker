<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $city_id
 * @property string $created
 * @property string $data
 * @property int $provider_id
 */
class ForecastRecord extends ActiveRecord
{
    public static function primaryKey()
    {
        return ['id'];
    }

    public static function tableName()
    {
        return '{{%forecast}}';
    }

    public function attributes()
    {
        return ['id', 'city_id', 'created', 'data', 'provider_id'];
    }

    public function rules()
    {
        return [
            [['id', 'city_id', 'provider_id'], 'integer'],
            [['data', 'created'], 'safe'],
        ];
    }
}