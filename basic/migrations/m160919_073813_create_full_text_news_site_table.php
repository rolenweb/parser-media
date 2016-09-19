<?php

use yii\db\Migration;

/**
 * Handles the creation for table `full_text_news_site`.
 */
class m160919_073813_create_full_text_news_site_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('full_text_news_site', [
            'id' => $this->primaryKey(),
            'news_site_id' => $this->integer(),
            'sourse_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('full_text_news_site');
    }
}
