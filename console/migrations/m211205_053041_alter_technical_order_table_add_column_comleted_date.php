<?php

use yii\db\Migration;

/**
 * Class m211205_053041_alter_technical_order_table_add_column_comleted_date
 */
class m211205_053041_alter_technical_order_table_add_column_comleted_date extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%technical_order}}', 'completed_date', $this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%technical_order}}', 'completed_date');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211205_053041_alter_technical_order_table_add_column_comleted_date cannot be reverted.\n";

        return false;
    }
    */
}
