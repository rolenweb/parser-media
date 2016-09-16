<?php

use yii\db\Migration;

/**
 * Handles the creation for table `setting`.
 */
class m160916_050257_create_setting_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('setting', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'value' => $this->string(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->insert('setting', 
            [
                'name' => 'antigate',
                'value' => '5e570dfb723b4f0d95e6591870e2052f',
                'created_at' => time(),
                'updated_at' => time(),
            ]
            
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('setting');
    }
}
