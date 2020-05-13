<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sms}}`.
 */
class m200513_094242_create_sms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sms}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'patient_id' => $this->integer(),
            'phone' => $this->string(),
            'sms_id' => $this->integer(),
            'status' => $this->string(),
            'type' => $this->string(),
            'text' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%sms}}');
    }
}
