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
//        \Yii::$app->db
//            ->createCommand('CREATE DATABASE IF NOT EXISTS `wwp`;')
//            ->execute();
        \Yii::$app->db
            ->createCommand('CREATE TABLE IF NOT EXISTS `wwp`.`city` (`id` int(11) NOT NULL AUTO_INCREMENT, `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB;')
            ->execute();
        \Yii::$app->db
            ->createCommand('ALTER TABLE `wwp`.`city` ADD UNIQUE (`name`); ')
            ->execute();
        \Yii::$app->db
            ->createCommand('INSERT IGNORE INTO `wwp`.`city` (`id`, `name`) VALUES (NULL, "Новосибирк"), (NULL, "Омск"), (NULL, "Томск");')
            ->execute();
    }
}
