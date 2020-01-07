<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%region}}`.
 */
class m200106_042042_add_type_column_to_region_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%region}}', 'type', $this->string(50));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%region}}', 'type');
    }
}
