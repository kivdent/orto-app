<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%invoice}}`.
 */
class m200404_012912_add_type_column_to_invoice_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%invoice}}', 'type', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%invoice}}', 'type');
    }
}
