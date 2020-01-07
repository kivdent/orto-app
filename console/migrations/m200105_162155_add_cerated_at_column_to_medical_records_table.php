<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%medical_records}}`.
 */
class m200105_162155_add_cerated_at_column_to_medical_records_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%medical_records}}', 'created_at', $this->dateTime());
        $this->addColumn('{{%medical_records}}', 'updated_at', $this->dateTime());
        $this->addColumn('{{%medical_records}}', 'date', $this->dateTime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%medical_records}}', 'created_at');
        $this->dropColumn('{{%medical_records}}', 'updated_at');
        $this->dropColumn('{{%medical_records}}', 'date');
    }
}
