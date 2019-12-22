<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%operation}}`.
 */
class m191215_110747_create_operation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%operation}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'price_from'=>$this->integer(),
            'price_to'=>$this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%operation}}');
    }
}
