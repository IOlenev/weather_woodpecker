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
 * @property ForecastDetailRecord $forecastDetail - forecast detail relation
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
        return ['id', 'city_id', 'created', 'provider_id', 'name', 'html'];
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
            ->select('`city`.`name`, `forecast`.`created`, `forecast_detail`.`html`')
            ->from(static::tableName())
            ->innerJoin('`city`', '`city`.`id` = `forecast`.`city_id`')
            ->innerJoin('`forecast_detail`', '`forecast_detail`.`id` = `forecast`.`id`')
            ->orderBy('`forecast`.`id` DESC');
    }

    /**
     * city forecast details hasOne relation query
     * @return ActiveQuery
     */
    public function getForecastDetail()
    {
        return $this->hasOne(ForecastDetailRecord::class, ['id' => 'id']);
    }

    public function add($cityId, $data)
    {
        try {
            $transaction = \Yii::$app->db->beginTransaction();
//                if ($result) {
//                    $result = json_decode($result, true);
//                }

            $this->city_id = $cityId;
            $this->provider_id = \Yii::$app->weather->getProviderId();
            $result = $this->save();

            if ($result) {
                $forecastDetail = new ForecastDetailRecord();
                $forecastDetail->id = $this->primaryKey;
                $forecastDetail->data = [];
                $forecastDetail->html = $data;
                $result = $forecastDetail->save();
            }

            if (!$result) {
                throw new \Exception('db error');
            }

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
        }
        return $result;
    }
}