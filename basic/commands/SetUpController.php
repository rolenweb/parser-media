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
class SetUpController extends BaseCommand
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex()
    {
    	$this->success('Creation dir: '.Yii::$app->basePath. DIRECTORY_SEPARATOR .'cookiefile');
    	mkdir(Yii::$app->basePath. DIRECTORY_SEPARATOR .'cookiefile',0777);
    	$this->success('Creation dir: '.Yii::$app->basePath. DIRECTORY_SEPARATOR .'recognize');
    	mkdir(Yii::$app->basePath. DIRECTORY_SEPARATOR .'recognize',0777);
    	$this->success('Creation dir: '.Yii::$app->basePath. DIRECTORY_SEPARATOR .'commands'. DIRECTORY_SEPARATOR .'files');
    	mkdir(Yii::$app->basePath. DIRECTORY_SEPARATOR .'commands'. DIRECTORY_SEPARATOR .'files',0777);
    	$this->success('Creation dir: '.Yii::$app->basePath. DIRECTORY_SEPARATOR .'commands'. DIRECTORY_SEPARATOR .'files'. DIRECTORY_SEPARATOR .'mail');
    	mkdir(Yii::$app->basePath. DIRECTORY_SEPARATOR .'commands'. DIRECTORY_SEPARATOR .'files'. DIRECTORY_SEPARATOR .'mail',0777);
        
    }
}
