<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%call_list}}`.
 */
class m230115_114129_create_call_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%call_list}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'Description' => $this->string(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'employee_id' => $this->integer()->notNull(),
            'type' => $this->string()->notNull()->defaultValue('type_users'),
            'status' => $this->string()->notNull()->defaultValue('status_active'),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%call_list}}');
    }
}
