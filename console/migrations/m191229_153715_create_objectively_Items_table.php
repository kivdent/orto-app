<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%objectively_items}}`.
 */
class m191229_153715_create_objectively_Items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%objectively_items}}', [
            'id' => $this->primaryKey(),
            'objectively_id' => $this->integer()->notNull(),
            'type' => $this->string('25')->notNull(),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%objectively_items}}');
    }
}
