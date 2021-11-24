<?php
namespace app\commands;

use yii\console\Controller;

/**
 * Console actions controller
 */
class InitdbController extends Controller
{
    public function actionIndex()
    {
        \Yii::$app->db
            ->createCommand('CREATE TABLE IF NOT EXISTS `city` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB')
            ->execute();
        \Yii::$app->db
            ->createCommand('ALTER TABLE `city` ADD UNIQUE `city` (`name` ASC);')
            ->execute();
        \Yii::$app->db
            ->createCommand('CREATE TABLE IF NOT EXISTS `forecast` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `city_id` int(11) UNSIGNED NOT NULL COMMENT "city table relation",
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data` json NOT NULL,
  `provider_id` tinyint(1) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `city_id` (`city_id`)
) ENGINE=InnoDB')
            ->execute();
        \Yii::$app->db
            ->createCommand('SET FOREIGN_KEY_CHECKS = 0;')
            ->execute();
        \Yii::$app->db
            ->createCommand('ALTER TABLE `forecast` ADD CONSTRAINT `forecast_fk` FOREIGN KEY (`city_id`) REFERENCES `city`(`id`) ON DELETE CASCADE;')
            ->execute();
        \Yii::$app->db
            ->createCommand('SET FOREIGN_KEY_CHECKS = 1;')
            ->execute();
        \Yii::$app->db
            ->createCommand('INSERT IGNORE INTO `city` (`id`, `name`) VALUES (NULL, "Новосибирcк"), (NULL, "Омск"), (NULL, "Томск");')
            ->execute();
    }
}
