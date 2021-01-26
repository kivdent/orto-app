php<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%klinikpat}}`.
 */
class m210124_100417_add_status_column_to_klinikpat_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%klinikpat}}', 'status', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%klinikpat}}', 'status');
    }
}
