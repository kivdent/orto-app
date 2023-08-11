<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%plan_item}}`.
 */
class m230713_031503_add_duration_from_column_to_plan_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%plan_item}}', 'duration_from', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%plan_item}}', 'duration_from');
    }
}
