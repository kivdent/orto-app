<?php

use yii\db\Migration;

/**
 * Class m200309_035214_alter_table_recommendations_alter_table_prescription_change_column_name
 */
class m200309_035214_alter_table_recommendations_alter_table_prescription_change_column_name extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('recommendations','name','string');
        $this->alterColumn('prescriptions','name','string');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('recommendations','name','string');
        $this->alterColumn('prescriptions','name','string');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200309_035214_alter_table_recommendations_alter_table_prescription_change_column_name cannot be reverted.\n";

        return false;
    }
    */
}
