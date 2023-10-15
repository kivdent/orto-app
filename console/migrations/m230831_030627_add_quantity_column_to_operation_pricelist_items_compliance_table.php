<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%operation_pricelist_items_compliance}}`.
 */
class m230831_030627_add_quantity_column_to_operation_pricelist_items_compliance_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%operation_pricelist_items_compliance}}', 'quantity', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%operation_pricelist_items_compliance}}', 'quantity');
    }
}
