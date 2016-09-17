<?php

use yii\db\Migration;

class m160917_115733_add_columnt_news_site_id_to_news extends Migration
{
    public function up()
    {
        $this->addColumn('news', 'news_site_id', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('news', 'news_site_id');
    }

    
}
