<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * @property int $id
 * @property string $name
 * @property string $lasttime - date and time of forecast last time gets
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
     * @return ActiveQuery
     */
    public static function getExpiredQuery()
    {
        return (new ActiveQuery(self::class))
            ->select('`city`.`id`, `city`.`name`, MAX(`forecast`.`created`) AS `lasttime`')
            ->from(ForecastRecord::tableName())
            ->innerJoin('`city`', '`city`.`id` = `forecast`.`city_id`')
            ->groupBy('`forecast`.`city_id`')
            ->having('ADDDATE(`lasttime`, INTERVAL 5 MINUTE) < NOW()');
    }
}