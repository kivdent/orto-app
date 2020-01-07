<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%objectively_sub_Items}}`.
 */
class m191230_090803_create_objectively_sub_Items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%objectively_sub_Items}}', [
            'id' => $this->primaryKey(),
            'objectively_Items_id' => $this->integer()->notNull(),
            'value' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%objectively_sub_Items}}');
    }
}
