<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "parse_key".
 *
 * @property integer $id
 * @property string $key
 * @property integer $type
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class ParseKey extends \yii\db\ActiveRecord
{

    const TYPE_RU = 1;
    const TYPE_EN = 2;
    
    const STATUS_ACTIVE = 1;
    const STATUS_PENDING = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parse_key';
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
            [['type', 'status', 'created_at', 'updated_at'], 'integer'],
            [['key'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Key',
            'type' => 'Type',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getTypeName()
    {
        if ($this->type == self::TYPE_RU) {
            return 'RU';
        }
        if ($this->type == self::TYPE_EN) {
            return 'EN';
        }
    }

    public function getStatusName()
    {
        if ($this->status == self::STATUS_ACTIVE) {
            return 'Активные';
        }
        if ($this->status == self::STATUS_PENDING) {
            return 'Пауза';
        }
    }

    public static function ddType()
    {
        return [
            self::TYPE_RU => 'RU',
            self::TYPE_EN => 'EN',
        ];
    }

    public static function ddStatus()
    {
        return [
            self::STATUS_ACTIVE => 'Активные',
            self::STATUS_PENDING => 'Паура',
        ];
    }

    public static function ddList()
    {
        return self::find()->where(['status' => self::STATUS_ACTIVE])->all();
    }
}
