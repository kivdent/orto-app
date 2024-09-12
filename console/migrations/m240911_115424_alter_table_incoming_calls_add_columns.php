<?php

use yii\db\Migration;

/**
 * Class m240911_115424_alter_table_incoming_calls_add_columns
 */
class m240911_115424_alter_table_incoming_calls_add_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%incoming_calls}}', 'specialization', $this->string());
        $this->addColumn('{{%incoming_calls}}', 'cost', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%incoming_calls}}', 'specialization');
        $this->dropColumn('{{%incoming_calls}}', 'cost');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240911_115424_alter_table_incoming_calls_add_columns cannot be reverted.\n";

        return false;
    }
    */
}
