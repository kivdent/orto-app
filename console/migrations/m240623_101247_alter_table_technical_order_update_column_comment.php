<?php

use yii\db\Migration;

/**
 * Class m240623_101247_alter_table_technical_order_update_column_comment
 */
class m240623_101247_alter_table_technical_order_update_column_comment extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('technical_order','comment',$this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('technical_order','comment',$this->string('255'));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240623_101247_alter_table_technical_order_update_column_comment cannot be reverted.\n";

        return false;
    }
    */
}
