<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%potential_for_rate}}`.
 */
class m241020_092720_add_financial_period_id_column_to_potential_for_rate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%potential_for_rate}}', 'financial_period_id', $this->integer());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%potential_for_rate}}', 'financial_period_id');

    }
}
