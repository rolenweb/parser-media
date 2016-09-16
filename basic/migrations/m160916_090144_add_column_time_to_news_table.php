<?php

use yii\db\Migration;

class m160916_090144_add_column_time_to_news_table extends Migration
{
    public function up()
    {
        $this->addColumn('news', 'time', $this->integer());
    }

    public function down()
    {
        
        $this->dropColumn('news', 'time');
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
