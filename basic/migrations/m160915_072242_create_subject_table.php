<?php

use yii\db\Migration;

/**
 * Handles the creation for table `subject`.
 */
class m160915_072242_create_subject_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('subject', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'url' => $this->string(),
            'resourse_id' => $this->integer(),
            'parse_key_id' => $this->integer(),
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
        $this->dropTable('subject');
    }
}
