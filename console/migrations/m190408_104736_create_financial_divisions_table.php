<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%financial_divisions}}`.
 */
class m190408_104736_create_financial_divisions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%financial_divisions}}', [
            'id' => $this->primaryKey(),
            'clinic_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'requisites' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%financial_divisions}}');
    }
}
