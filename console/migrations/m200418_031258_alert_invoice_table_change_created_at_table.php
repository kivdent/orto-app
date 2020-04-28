<?php

use yii\db\Migration;

/**
 * Class m200418_031258_alert_invoice_table_change_created_at_table
 */
class m200418_031258_alert_invoice_table_change_created_at_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('invoice', 'created_at', 'date');
        $this->alterColumn('invoice', 'updated_at', 'date');
        $this->createIndex('idx-invoice-created_at','invoice','created_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        {
            $this->alterColumn('invoice', 'created_at', 'DATETIME');
            $this->alterColumn('invoice', 'updated_at', 'DATETIME');
            $this->dropIndex('idx-invoice-created_at','invoice');
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200418_031258_alert_invoice_table_change_created_at_table cannot be reverted.\n";

        return false;
    }
    */
}
