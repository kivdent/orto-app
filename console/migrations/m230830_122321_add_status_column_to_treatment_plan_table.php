<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%treatment_plan}}`.
 */
class m230830_122321_add_status_column_to_treatment_plan_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%treatment_plan}}', 'status', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%treatment_plan}}', 'status');
    }
}
