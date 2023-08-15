<?php

use yii\db\Migration;

/**
 * Class m230815_113012_alter_table_rabmesto_change_column_nazv
 */
class m230815_113012_alter_table_rabmesto_change_column_nazv extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('rabmesto','nazv',$this->string('255'));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230815_113012_alter_table_rabmesto_change_column_nazv cannot be reverted.\n";

        return false;
    }
    */
}
