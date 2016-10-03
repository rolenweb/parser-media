<?php

use yii\db\Migration;

/**
 * Handles the creation for table `log`.
 */
class m161003_123056_create_log_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('log', [
            'id' => $this->primaryKey(),
            'object' => $this->string(),
            'object_id' => $this->integer(),
            'type' => $this->string(),
            'data' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('log');
    }
}
