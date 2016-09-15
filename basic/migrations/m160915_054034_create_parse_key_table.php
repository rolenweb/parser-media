<?php

use yii\db\Migration;

/**
 * Handles the creation for table `parse_key`.
 */
class m160915_054034_create_parse_key_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('parse_key', [
            'id' => $this->primaryKey(),
            'key' => $this->string(),
            'type' => $this->integer(),
            'status' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('parse_key');
    }
}
