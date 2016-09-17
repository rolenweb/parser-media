<?php

use yii\db\Migration;

class m160917_123048_create_index_news_url extends Migration
{
    public function up()
    {
        $this->createIndex('idx-news-url', '{{%news}}', ['url']);
    }

    public function down()
    {
        $this->dropIndex('idx-news-url', '{{%news}}');
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
