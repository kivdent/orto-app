<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%nazn}}`.
 */
class m231015_131203_add_created_at_column_to_nazn_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%nazn}}', 'created_at', $this->dateTime());
        $this->addColumn('{{%nazn}}', 'updated_at', $this->dateTime());
        $this->addColumn('{{%nazn}}', 'employee_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%nazn}}', 'created_at');
        $this->dropColumn('{{%nazn}}', 'updated_at');
        $this->dropColumn('{{%nazn}}', 'employee_id');

    }
}
