<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%medical_records}}`.
 */
class m191228_011136_create_medical_records_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%medical_records}}', [
            'id' => $this->primaryKey(),
            'region_id' => $this->integer(),
            'diagnosis_id' => $this->integer(),
            'complaints' => $this->text(),
            'anamnesis' => $this->text(),
            'objectively' => $this->text(),
            'recommendations' => $this->text(),
            'prescriptions' => $this->text(),
            'invoice_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%medical_records}}');
    }
}
