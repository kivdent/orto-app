<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pricelist}}`.
 */
class m200314_094249_create_pricelist_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pricelist}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'active' => $this->boolean(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%pricelist}}');
    }
}
