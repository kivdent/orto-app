<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%operation}}`.
 */
class m230713_033408_add_duration_from_column_to_operation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%operation}}', 'duration_from', $this->integer());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%operation}}', 'duration_from');

    }
}
