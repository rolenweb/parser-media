<?php

use yii\db\Migration;

/**
 * Handles the creation for table `category`.
 */
class m160917_062552_create_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'value' => $this->string(),
            'sourse_id' => $this->integer(),
            'status' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex('idx-category-name-value', '{{%category}}', ['name', 'value']);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex('idx-category-name-value', '{{%category}}');
        $this->dropTable('category');
    }
}
