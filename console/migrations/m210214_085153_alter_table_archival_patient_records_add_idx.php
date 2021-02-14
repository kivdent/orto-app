<?php

use yii\db\Migration;

/**
 * Class m210214_085153_alter_table_archival_patient_records_add_idx
 */
class m210214_085153_alter_table_archival_patient_records_add_idx extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('idx-archival_patient_records-patient_id', 'archival_patient_records', 'patient_id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-archival_patient_records-patient_id', 'archival_patient_records');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210214_085153_alter_table_archival_patient_records_add_idx cannot be reverted.\n";

        return false;
    }
    */
}
