<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%pricelist}}`.
 */
class m250319_104723_add_specialization_column_to_pricelist_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%pricelist}}', 'specialization', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%pricelist}}', 'specialization');
    }
}
