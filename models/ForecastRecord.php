<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $city_id
 * @property string $created
 * @property string $data
 * @property string $html
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
        return ['id', 'city_id', 'created', 'data', 'html', 'provider_id', 'name'];
    }

    public function rules()
    {
        return [
            [['id', 'city_id', 'provider_id'], 'integer'],
            [['data', 'created', 'html'], 'safe'],
        ];
    }

    /**
     * get last forecasts
     * @return ActiveQuery
     */
    public static function getLast()
    {
        return (new ActiveQuery(static::class))
            ->select('`city`.`name`, `forecast`.`created`, `forecast`.`data`, `forecast`.`html`')
            ->from(static::tableName())
            ->innerJoin('`city`', '`city`.`id` = `forecast`.`city_id`')
            ->orderBy('`forecast`.`id` DESC');
    }

}