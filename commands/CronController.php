<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;

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

        return ExitCode::OK;
    }
}
