<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%medical_records}}`.
 */
class m200105_153939_add_therapy_column_to_medical_records_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%medical_records}}', 'therapy', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%medical_records}}', 'therapy');
    }
}
