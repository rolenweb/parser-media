<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\components\LogDateBehavior;
/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $name
 * @property string $value
 * @property integer $sourse_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Category extends \yii\db\ActiveRecord
{

    const STATUS_ACTIVE = 1;
    const STATUS_PENDING = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            LogDateBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sourse_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'value'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'value' => 'Value',
            'sourse_id' => 'Sourse ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getStatusName()
    {
        if ($this->status == self::STATUS_ACTIVE) {
            return 'Активная';
        }
        if ($this->status == self::STATUS_PENDING) {
            return 'Пауза';
        }
        
    }

    public static function ddStatus()
    {
        return [
            self::STATUS_ACTIVE => 'Активная',
            self::STATUS_PENDING => 'Пауза',
        ];
    }

    public function getSourse()
    {
        return $this->hasOne(Sourse::className(), ['id' => 'sourse_id']);
    }
    
}
