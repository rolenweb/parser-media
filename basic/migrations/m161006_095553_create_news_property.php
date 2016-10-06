<?php

use yii\db\Migration;

class m161006_095553_create_news_property extends Migration
{
    public function up()
    {
        $this->createTable('news_property', [
            'id' => $this->primaryKey(),
            'sourse_id' => $this->integer(),
            'news_id' => $this->integer(),
            'css_selector_id' => $this->integer(),
            'value' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('news_property');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
