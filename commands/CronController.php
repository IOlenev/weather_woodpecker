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
        $aq = CityRecord::getNoForecast();
        if (!$aq->scalar()) {
            $aq = CityRecord::getExpiredQuery();
        }
        foreach ($aq->each() as $city) {
            $result = \Yii::$app->weather->byCity($city->name);

            if ($result) {
                (new ForecastRecord())->add($city->id, $result);
            }

            echo sprintf("\nGetting %s weather result: %s\n", $city->name, var_export($result, true));
            if (!$result) {
                echo sprintf("error message: %s\n", \Yii::$app->weather->getError());
            }
            //sleep(1);
        }
    }

    public function actionInitdb()
    {
        \Yii::$app->db
            ->createCommand('CREATE TABLE IF NOT EXISTS `city` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci')
            ->execute();
        \Yii::$app->db
            ->createCommand('ALTER TABLE `city` ADD UNIQUE `city` (`name` ASC);')
            ->execute();
        \Yii::$app->db
            ->createCommand('CREATE TABLE IF NOT EXISTS `forecast` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `city_id` int(11) UNSIGNED NOT NULL COMMENT "city table relation",
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `provider_id` tinyint(1) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci')
            ->execute();
        \Yii::$app->db
            ->createCommand('CREATE TABLE IF NOT EXISTS `forecast_detail` (
    `id` INT(11) UNSIGNED NOT NULL ,
    `data` JSON NULL ,
    `html` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
    UNIQUE (`id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;')
            ->execute();
        \Yii::$app->db
            ->createCommand('SET FOREIGN_KEY_CHECKS = 0;')
            ->execute();
        \Yii::$app->db
            ->createCommand('ALTER TABLE `forecast` ADD CONSTRAINT `forecast_fk` FOREIGN KEY (`city_id`) REFERENCES `city`(`id`) ON DELETE CASCADE;')
            ->execute();
        \Yii::$app->db
            ->createCommand('ALTER TABLE `forecast_detail` ADD CONSTRAINT `forecast_detail_fk` FOREIGN KEY (`id`) REFERENCES `forecast`(`id`) ON DELETE CASCADE;')
            ->execute();
        \Yii::$app->db
            ->createCommand('SET FOREIGN_KEY_CHECKS = 1;')
            ->execute();
        \Yii::$app->db
            ->createCommand('ALTER TABLE `forecast` ADD INDEX (`city_id`, `created`);')
            ->execute();
        \Yii::$app->db
            ->createCommand('INSERT IGNORE INTO `city` (`id`, `name`) VALUES (NULL, "Новосибирск"), (NULL, "Омск"), (NULL, "Томск");')
            ->execute();
    }
}
