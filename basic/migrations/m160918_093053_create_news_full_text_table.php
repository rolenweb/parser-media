<?php

use yii\db\Migration;

/**
 * Handles the creation for table `news_full_text`.
 */
class m160918_093053_create_news_full_text_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('news_full_text', [
            'id' => $this->primaryKey(),
            'text' => $this->text(),
            'news_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('news_full_text');
    }
}
