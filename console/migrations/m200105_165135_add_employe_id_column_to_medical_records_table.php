<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%medical_records}}`.
 */
class m200105_165135_add_employe_id_column_to_medical_records_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%medical_records}}', 'employe_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%medical_records}}', 'employe_id');
    }
}
