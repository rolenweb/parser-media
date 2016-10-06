<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\components\LogDateBehavior;

/**
 * This is the model class for table "news_property".
 *
 * @property integer $id
 * @property string $name
 * @property integer $sourse_id
 * @property integer $news_id
 * @property integer $css_selector_id
 * @property string $value
 * @property integer $created_at
 * @property integer $updated_at
 */
class NewsProperty extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news_property';
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
            [['sourse_id', 'news_id', 'css_selector_id', 'created_at', 'updated_at'], 'integer'],
            [['value'], 'string'],
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
            'sourse_id' => 'Sourse ID',
            'news_id' => 'News ID',
            'css_selector_id' => 'Css Selector ID',
            'value' => 'Value',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getCssSelector()
    {
        return $this->hasOne(CssSelector::className(), ['id' => 'css_selector_id']);
    }
}
