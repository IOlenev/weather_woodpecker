<?php
namespace app\commands;

use app\models\CityRecord;
use app\models\ForecastRecord;
use yii\console\Controller;

/**
 * Console actions controller
 */
class CronController extends Controller
{
    /**
     * Weather API call action
     * @return int Exit code
     */
    public function actionIndex()
    {
        /**
         * @var CityRecord $city
         */
        foreach (CityRecord::find()->each() as $city) {
            $result = \Yii::$app->weather->byCity($city->name);
            if ($result) {
                $result = json_decode($result, true);
            }
            if ($result) {
                $forecast = new ForecastRecord();
                $forecast->city_id = $city->id;
                $forecast->provider_id = \Yii::$app->weather->getProviderId();
                $forecast->created = (new \DateTime())->format('Y-m-d H:i:s');
                $forecast->data = $result;
                $result = $forecast->save();
            }

            echo sprintf("\nGetting %s weather result: %s\n", $city->name, var_export($result, true));
            if (!$result) {
                echo sprintf("error message: %s\n", $result = \Yii::$app->weather->getError());
            }
            sleep(2);
        }
    }
}
