<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\components\LogDateBehavior;

/**
 * This is the model class for table "css_selector".
 *
 * @property integer $id
 * @property string $name
 * @property string $selector
 * @property string $type
 * @property integer $sourse_id
 * @property integer $news_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class CssSelector extends \yii\db\ActiveRecord
{
    const STR = 'string';
    const ATTR = 'attribute';
    const LINK = 'link';

    const NAME_TITLE = 'title';
    const NAME_URL = 'url';
    const NAME_DESCRIPTION = 'description';
    const NAME_IMAGE = 'image';
    const NAME_DATE = 'date';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'css_selector';
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
            [['sourse_id', 'news_id', 'created_at', 'updated_at'], 'integer'],
            [['name', 'selector', 'type','attr'], 'string', 'max' => 255],
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
            'selector' => 'Selector',
            'type' => 'Type',
            'attr' => 'Attr',
            'sourse_id' => 'Sourse ID',
            'news_id' => 'News ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function ddType()
    {
        return [
            self::STR => self::STR,
            self::ATTR => self::ATTR,
            self::LINK => self::LINK,
        ];
    }

    public function getSourse()
    {
        return $this->hasOne(Sourse::className(), ['id' => 'sourse_id']);
    }

    public function getNewsSite()
    {
        return $this->hasOne(NewsSites::className(), ['id' => 'news_id']);
    }
}
