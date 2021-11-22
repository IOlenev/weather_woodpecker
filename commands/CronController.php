<?php
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
        echo 'cron';
        return ExitCode::OK;
    }
}
