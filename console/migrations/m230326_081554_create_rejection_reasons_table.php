<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%rejection_reasons}}`.
 */
class m230326_081554_create_rejection_reasons_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%rejection_reasons}}', [
            'id' => $this->primaryKey()->notNull(),
            'title' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%rejection_reasons}}');
    }
}
