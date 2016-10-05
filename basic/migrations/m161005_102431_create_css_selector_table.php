<?php

use yii\db\Migration;

/**
 * Handles the creation for table `css_selector`.
 */
class m161005_102431_create_css_selector_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('css_selector', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'selector' => $this->string(),
            'type' => $this->string(),
            'sourse_id' => $this->integer(),
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
        $this->dropTable('css_selector');
    }
}
