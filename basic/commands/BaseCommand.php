<?php
namespace app\commands;

use yii\console\Controller;
use yii\helpers\Console;

class BaseCommand extends Controller
{
	protected $time = 0;
	public $verbose = false;
	public $trace = false;
	public $clear = false;
	protected $asciiGfx = <<<'DOC'
  ____                     ____
 /___/\_                  /___/\
|   |/  \\\\\\\\\\\\\'\  |   |/\|
|___|\___\\\\\\\\\\\\\/  |___|\/|
 \___\/                   \___\/
DOC;
	protected $asciiName = <<<'DOC'
  _____                           __  __          _ _       
 |  __ \                         |  \/  |        | (_)      
 | |__) |_ _ _ __ ___  ___ _ __  | \  / | ___  __| |_  __ _ 
 |  ___/ _` | '__/ __|/ _ \ '__| | |\/| |/ _ \/ _` | |/ _` |
 | |  | (_| | |  \__ \  __/ |    | |  | |  __/ (_| | | (_| |
 |_|   \__,_|_|  |___/\___|_|    |_|  |_|\___|\__,_|_|\__,_|

DOC;

	public function options($actionID)
	{
		return [
			'verbose',
			'trace',
			'clear',
		];
	}

	public function optionAliases()
	{
		return [
			'v' => 'verbose',
			't' => 'trace',
			'c' => 'clear',
		];
	}

	public function beforeAction($action)
	{
		if ($this->clear) {
			Console::clearScreen();
			echo "\033[3J"; // clear Putty scrollback buffer
		}
		Console::output(Console::ansiFormat($this->asciiGfx, [94]));
		Console::output(Console::ansiFormat($this->asciiName, [92]));
		return parent::beforeAction($action);
	}

	protected static function success($message)
	{
		Console::output(Console::ansiFormat($message, [Console::FG_GREEN]));
	}

	protected static function error($message)
	{
		Console::output(Console::ansiFormat($message, [Console::FG_RED]));
	}

	protected function whisper($message)
	{
		if ($this->verbose) {
			Console::output(Console::ansiFormat($message, [90]));
		}
	}

	protected function trace($message)
	{
		if ($this->trace) {
			$time = microtime(true);
			$delta = $time - $this->time;
			if ($this->time === 0) {
				$timestr = (new \DateTime)->format('Y-m-d H:i:s');
			} else {
				$timestr = number_format($delta, 2, '.', '') . 's';
			}
			Console::output(Console::ansiFormat($timestr . ' - ' . $message, [35]));
			$this->time = $time;
		}
	}

	protected function readStdin()
	{
		while ($line = fgets(STDIN)) {
			yield $line;
		}
	}
}
