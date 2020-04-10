<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%invoice}}`.
 */
class m200403_095117_create_invoice_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%invoice}}', [
            'id' => $this->primaryKey(),
            'doctor_id' => $this->integer(),
            'patient_id' => $this->integer(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'amount' => $this->integer(),
            'amount_payable' => $this->integer(),
            'paid' => $this->integer()->defaultValue(0),
            'discount_id' => $this->integer()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%invoice}}');
    }
}
