<?php

use yii\db\Migration;

/**
 * Class m240911_124211_alter_table_incoming_calls_add_columns_patient_id
 */
class m240911_124211_alter_table_incoming_calls_add_columns_patient_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%incoming_calls}}', 'patient_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%incoming_calls}}', 'patient_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240911_124211_alter_table_incoming_calls_add_columns_patient_id cannot be reverted.\n";

        return false;
    }
    */
}
