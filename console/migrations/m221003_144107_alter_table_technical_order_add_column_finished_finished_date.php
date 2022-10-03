<?php

use yii\db\Migration;

/**
 * Class m221003_144107_alter_table_technical_order_add_column_finished_finished_date
 */
class m221003_144107_alter_table_technical_order_add_column_finished_finished_date extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('technical_order', 'finished', $this->boolean());
        $this->addColumn('technical_order', 'finished_date', $this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
     $this->dropColumn('technical_order','finished');
     $this->dropColumn('technical_order','finished_date');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221003_144107_alter_table_technical_order_add_column_finished_finished_date cannot be reverted.\n";

        return false;
    }
    */
}
