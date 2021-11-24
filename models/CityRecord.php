<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $name
 */
class CityRecord extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%city}}';
    }

    public function attributes()
    {
        return ['id', 'name'];
    }

}