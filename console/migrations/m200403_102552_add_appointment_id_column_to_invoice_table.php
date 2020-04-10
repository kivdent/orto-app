<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%invoice}}`.
 */
class m200403_102552_add_appointment_id_column_to_invoice_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%invoice}}', 'appointment_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%invoice}}', 'appointment_id');
    }
}
