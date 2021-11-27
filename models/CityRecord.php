<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Table `city` active record class
 * @property int $id
 * @property string $name
 * @property string $lasttime - date and time of forecast last time gets
 * @property ForecastRecord[] $forecasts - city forecasts relation
 */
class CityRecord extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%city}}';
    }

    public function attributes()
    {
        return ['id', 'name', 'lasttime'];
    }

    /**
     * expired forecast cities query
     * @return ActiveQuery
     */
    public static function getExpiredQuery()
    {
        return (new ActiveQuery(static::class))
            ->select('`city`.`id`, `city`.`name`, MAX(`forecast`.`created`) AS `lasttime`')
            ->from(ForecastRecord::tableName())
            ->innerJoin('`city`', '`city`.`id` = `forecast`.`city_id`')
            ->groupBy('`forecast`.`city_id`')
            ->having('ADDDATE(`lasttime`, INTERVAL 10 MINUTE) < NOW()');
    }

    /**
     * cities with no forecast query
     * @return ActiveQuery
     */
    public static function getNoForecast()
    {
        return (new ActiveQuery(static::class))
            ->select('`city`.`id`, `city`.`name`')
            ->from(static::tableName())
            ->leftJoin('`forecast`', '`city`.`id` = `forecast`.`city_id`')
            ->where('ISNULL(`forecast`.`id`)');
    }

    /**
     * city forecasts hasMany relation query
     * @return ActiveQuery
     */
    public function getForecasts()
    {
        return $this->hasMany(ForecastRecord::class, ['city_id' => 'id']);
    }
}