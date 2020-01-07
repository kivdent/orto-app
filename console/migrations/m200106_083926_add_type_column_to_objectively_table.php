<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%objectively}}`.
 */
class m200106_083926_add_type_column_to_objectively_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%objectively}}', 'type', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%objectively}}', 'type');
    }
}
