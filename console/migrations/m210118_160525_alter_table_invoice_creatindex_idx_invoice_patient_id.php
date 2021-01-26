<?php

use yii\db\Migration;

/**
 * Class m210118_160525_alter_table_invoice_creatindex_idx_invoice_patient_id
 */
class m210118_160525_alter_table_invoice_creatindex_idx_invoice_patient_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('idx-invoice-patient_id', 'invoice', 'patient_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-invoice-patient_id', 'invoice');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210118_160525_alter_table_invoice_creatindex_idx_invoice_patient_id cannot be reverted.\n";

        return false;
    }
    */
}
