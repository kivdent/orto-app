<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%operation_pricelist_items_compliance}}`.
 */
class m230831_022404_create_operation_pricelist_items_compliance_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%operation_pricelist_items_compliance}}', [
            'id' => $this->primaryKey(),
            'operation_id' => $this->integer(),
            'pricelist_item_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%operation_pricelist_items_compliance}}');
    }
}
