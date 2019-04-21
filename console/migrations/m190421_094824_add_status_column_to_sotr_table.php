<?php

use yii\db\Migration;
/**
 * Handles adding status to table `{{%sotr}}`.
 */
class m190421_094824_add_status_column_to_sotr_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%sotr}}', 'status', $this->string()->notNull()->defaultValue('Работает'));
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%sotr}}', 'status');
        
    }
}
