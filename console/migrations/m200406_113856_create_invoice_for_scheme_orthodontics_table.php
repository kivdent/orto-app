<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%invoice_for_scheme_orthodontics}}`.
 */
class m200406_113856_create_invoice_for_scheme_orthodontics_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%invoice_for_scheme_orthodontics}}', [
            'invoice_id' => $this->integer(),
            'scheme_orthodontics_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%invoice_for_scheme_orthodontics}}');
    }
}
