<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%addresses}}`.
 */
class m190408_093614_create_addresses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%addresses}}', [
            'id' => $this->primaryKey(),
            'postcode' => $this->integer()->notNull(),
            'city' => $this->string(25),
            'street' => $this->string(100)->notNull(),
            'house' => $this->string(20)->notNull(),
            'apartment' => $this->string(10),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%addresses}}');
    }
}
