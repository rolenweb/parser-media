<?php

use yii\db\Migration;

/**
 * Handles the creation for table `subject_category`.
 */
class m160917_073453_create_subject_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('subject_category', [
            'id' => $this->primaryKey(),
            'subject_id' => $this->integer(),
            'category_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

//        $this->createIndex('idx-subject_category-subject_id-category_id', '{{%subject_category}}', ['subject_id', 'category_id']);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
  //      $this->dropIndex('idx-subject_category-subject_id-category_id', '{{%subject_category}}');
        $this->dropTable('subject_category');
    }
}
