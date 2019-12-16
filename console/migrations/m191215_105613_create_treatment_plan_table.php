<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%treatment_plan}}`.
 */
class m191215_105613_create_treatment_plan_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%treatment_plan}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'author' => $this->integer(),
            'patient' => $this->integer(),
            'comments' => $this->text(),
            'deleted' => $this->boolean(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%treatment_plan}}');
    }
}
