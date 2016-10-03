<?php
namespace app\components;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use app\models\Log;
use app\models\Helper;
use yii\helpers\Json;

class LogDateBehavior extends Behavior
{
    const CONSOLE = 99999999;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'logDateCreated',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'logDateModifed',
            
        ];
    }

    public function logDateCreated()
    {

        if ($this->owner->attributes != NULL) {
            $log_date = [];
            foreach ($this->owner->attributes as $key => $attribute) {
                if ($attribute !== NULL) {
                    $log_data[$key]['from'] = NULL;
                    $log_data[$key]['to'] = $attribute;
                }
                
            }
            
            
             (new Log())->logData($this->owner->tableName(), $this->owner->id,Json::encode($log_data), 'created');
        }
       
    }

    public function logDateModifed()
    {

        if ($this->owner->attributes != NULL) {
            $log_date = [];
            $par_data = [];
            $old_art = $this->owner->oldAttributes;
            foreach ($this->owner->attributes as $key => $attribute) {
                if ($attribute !== $old_art[$key]) {
                    $log_data[$key]['from'] = $old_art[$key];
                    $log_data[$key]['to'] = $attribute;
                    
                }
                
            }
            
             (new Log())->logData($this->owner->tableName(), $this->owner->id,Json::encode($log_data), 'modified');

             
        }
       
    }

}

?>