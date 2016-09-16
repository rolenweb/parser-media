<?php

use yii\db\Migration;

/**
 * Handles adding subject_id to table `news`.
 */
class m160915_073353_add_subject_id_column_to_news_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('news', 'subject_id', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('news', 'subject_id');
    }
}
