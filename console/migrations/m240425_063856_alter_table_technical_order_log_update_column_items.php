<?php

use yii\db\Migration;

/**
 * Class m240425_063856_alter_table_technical_order_log_update_column_items
 */
class m240425_063856_alter_table_technical_order_log_update_column_items extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('technical_order_log','items',$this->text());


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('technical_order_log','items',$this->string('255'));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240425_063856_alter_table_technical_order_log_update_column_items cannot be reverted.\n";

        return false;
    }
    */
}
