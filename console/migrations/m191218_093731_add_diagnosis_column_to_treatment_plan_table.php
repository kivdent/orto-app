<?php

use yii\db\Migration;

/**
 * Handles adding diagnosis to table `{{%treatment_plan}}`.
 */
class m191218_093731_add_diagnosis_column_to_treatment_plan_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%treatment_plan}}', 'diagnosis_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%treatment_plan}}', 'diagnosis');
    }
}
