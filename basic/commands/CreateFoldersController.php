<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii;
use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CreateFoldersController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex()
    {
        if (!file_exists(Yii::getAlias('@app').'/recognize/')) {
            mkdir(Yii::getAlias('@app').'/recognize/', 0777);
        }
        if (!file_exists(Yii::getAlias('@app').'/cookiefile/')) {
            mkdir(Yii::getAlias('@app').'/cookiefile/', 0777);
        }
    }
}
