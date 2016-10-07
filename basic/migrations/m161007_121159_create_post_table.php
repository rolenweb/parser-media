<?php

use yii\db\Migration;

/**
 * Handles the creation for table `post`.
 */
class m161007_121159_create_post_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('post', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'preview' => $this->text(),
            'content' => $this->text(),
            'sourse_id' => $this->integer(),
            'subject_id' => $this->integer(),
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
        $this->dropTable('post');
    }
}
