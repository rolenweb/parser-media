<?php

use yii\db\Migration;

class m160916_052642_insert_setting_proxy extends Migration
{
    public function up()
    {
         $this->insert('setting', 
            [
                'name' => 'proxy',
                'value' => '2',
                'created_at' => time(),
                'updated_at' => time(),
            ]
            
        );
    }

    public function down()
    {
        $this->delete('setting',['name' => 'proxy']);    
    }

    
}
