<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "sourse".
 *
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property integer $type
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Sourse extends \yii\db\ActiveRecord
{

    const TYPE_MEDIA = 1;
    const TYPE_RSS = 2;
    const STATUS_ACTIVE = 1;
    const STATUS_PENDING = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sourse';
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
            [['name', 'url'], 'string', 'max' => 255],
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
            'url' => 'Url',
            'type' => 'Type',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getTypeName()
    {
        if ($this->type == self::TYPE_MEDIA) {
            return 'СМИ';
        }
        if ($this->type == self::TYPE_RSS) {
            return 'RSS';
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
            self::TYPE_MEDIA => 'СМИ',
            self::TYPE_RSS => 'RSS',
        ];
    }

    public static function ddStatus()
    {
        return [
            self::STATUS_ACTIVE => 'Активные',
            self::STATUS_PENDING => 'Паура',
        ];
    }
}
