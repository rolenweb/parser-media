<?php

use yii\db\Migration;

/**
 * Handles adding attr to table `css_selector`.
 */
class m161006_092148_add_attr_column_to_css_selector_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('css_selector', 'attr', $this->string());
    }

    public function down()
    {
        $this->dropColumn('css_selector', 'attr');
    }
}
