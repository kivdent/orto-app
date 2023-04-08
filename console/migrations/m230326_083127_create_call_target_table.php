<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%call_target}}`.
 */
class m230326_083127_create_call_target_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%call_target}}', [
            'id' => $this->primaryKey()->notNull(),
            'title' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%call_target}}');
    }
}
