<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "log".
 *
 * @property integer $id
 * @property string $object
 * @property integer $object_id
 * @property string $type
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at
 */
class Log extends \yii\db\ActiveRecord
{
    const CREATED = 'created';
    const MODIFIED = 'modified';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['object_id', 'created_at', 'updated_at'], 'integer'],
            [['data'], 'string'],
            [['object', 'type'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'object' => 'Object',
            'object_id' => 'Object ID',
            'type' => 'Type',
            'data' => 'Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function newRecord($obj, $obj_id, $ass, $data = NULL)
    {
        $new_rec = new $this;
        $new_rec->object = $obj;
        $new_rec->object_id  = $obj_id;
        $new_rec->type = $ass;
        $new_rec->data = $data;
        $new_rec->save();
    }

    public function logData($type_object, $records_id, $data, $ass = 'modified'){
            
            //create log data
            $this->newRecord($type_object,  $records_id, $ass, $data);
            //create log data    
            return;
    } 

    public function displayData()
    {
        $out = '';
        if (empty($this->data)) {
            return;
        }else{
            $arr = json_decode($this->data);
            foreach ($arr as $key => $item) {
                $out .= '<div><b>'.$key.':</b> from: '.$item->from.' to: '.$item->to.'</div>';
            }
        }
        return $out;
    }
}
