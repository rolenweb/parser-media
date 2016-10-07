<?php

use yii\db\Migration;

/**
 * Handles adding fulltext to table `news_sites`.
 */
class m161007_055755_add_fulltext_column_to_news_sites_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('news_sites', 'fulltext', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('news_sites', 'fulltext');
    }
}
