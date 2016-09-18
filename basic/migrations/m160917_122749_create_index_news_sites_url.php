<?php

use yii\db\Migration;

class m160917_122749_create_index_news_sites_url extends Migration
{
    public function up()
    {
        //$this->createIndex('idx-news_sites-url', '{{%news_sites}}', ['url']);
    }

    public function down()
    {
        //$this->dropIndex('idx-news_sites-url', '{{%news_sites}}');
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
