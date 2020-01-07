<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%medical_records}}`.
 */
class m200105_172239_add_patient_id_column_to_medical_records_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%medical_records}}', 'patient_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%medical_records}}', 'patient_id');
    }
}
