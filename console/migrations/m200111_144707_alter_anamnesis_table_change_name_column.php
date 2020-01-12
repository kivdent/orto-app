<?php

use yii\db\Migration;

/**
 * Class m200111_144707_alter_anamnesis_table_change_name_column
 */
class m200111_144707_alter_anamnesis_table_change_name_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('anamnesis','name','string');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('anamnesis','name','string');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200111_144707_alter_anamnesis_table_change_name_column cannot be reverted.\n";

        return false;
    }
    */
}
