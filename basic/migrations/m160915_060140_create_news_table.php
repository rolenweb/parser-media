<?php

use yii\db\Migration;

/**
 * Handles the creation for table `news`.
 */
class m160915_060140_create_news_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('news', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'preview' => $this->text(),
            'url' => $this->string(),
            'description_id' => $this->integer(),
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
        $this->dropTable('news');
    }
}
