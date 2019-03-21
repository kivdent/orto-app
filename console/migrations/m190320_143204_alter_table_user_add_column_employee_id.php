<?php

use yii\db\Migration;

/**
 * Class m190320_143204_alter_table_user_add_column_employee_id
 */
class m190320_143204_alter_table_user_add_column_employee_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'employe_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'employe_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190320_143204_alter_table_user_add_column_employee_id cannot be reverted.\n";

        return false;
    }
    */
}
