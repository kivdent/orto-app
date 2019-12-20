<?php

use yii\db\Migration;

/**
 * Handles adding code to table `{{%ds}}`.
 */
class m191219_043643_add_code_column_to_ds_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%ds}}', 'code', $this->string(50));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%ds}}', 'code');
    }
}
