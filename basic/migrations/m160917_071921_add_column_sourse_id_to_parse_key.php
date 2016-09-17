<?php

use yii\db\Migration;

class m160917_071921_add_column_sourse_id_to_parse_key extends Migration
{
    public function up()
    {
        $this->addColumn('parse_key', 'sourse_id', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('parse_key', 'sourse_id');
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
