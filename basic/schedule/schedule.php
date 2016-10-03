<?php
/**
 * @var \omnilight\scheduling\Schedule $schedule
 */

// Place here all of your cron jobs
//namespace app\schedule;

//use app\models\EmailSetting;

//$modelsemailform = EmailSetting::find()->where(['status' => 1])->all();

/*foreach ($modelsemailform as $modelemailform) {
	echo $modelemailform->time."test\n";
	$par_time = date("G:i",strtotime($modelemailform->time))."\n";

	// This command will execute ls command every five minutes
	$schedule->command('notice/developer')->dailyAt($par_time);
}
*/
//$schedule->command('notice/developer')->cron('* * * * *');
//$schedule->command('notice')->cron('* * * * *');
//$schedule->command('contract-nonconformance')->cron('* * * * *');
///usr/bin/php /var/www/admin/www/parser-media.devsym.ru/basic/yii schedule/run --scheduleFile=@app/schedule/schedule.php

//
$schedule->command('subject-parser')->everyFiveMinutes();
//$schedule->command('full-text-parser')->everyFiveMinutes();