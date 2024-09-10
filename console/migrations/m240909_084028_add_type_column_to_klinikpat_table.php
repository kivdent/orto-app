<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%klinikpat}}`.
 */
class m240909_084028_add_type_column_to_klinikpat_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%klinikpat}}', 'type', $this->string()->defaultValue('patient'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%klinikpat}}', 'type');
    }
}
