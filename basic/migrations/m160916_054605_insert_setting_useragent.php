<?php

use yii\db\Migration;

class m160916_054605_insert_setting_useragent extends Migration
{
    public function up()
    {
        $this->insert('setting', 
            [
                'name' => 'useragent',
                'value' => 'Opera/9.62 (Windows NT 6.0; U; ru) Presto/2.1.1',
                'created_at' => time(),
                'updated_at' => time(),
            ]
            
        );
    }

    public function down()
    {
        $this->delete('setting',['name' => 'useragent']);    
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
