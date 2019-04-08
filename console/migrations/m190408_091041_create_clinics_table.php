<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%clinics}}`.
 */
class m190408_091041_create_clinics_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%clinics}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'address' => $this->integer(),
            'phone' => $this->string(),
            'record_phone' => $this->string(),
            'additional_phones' => $this->text(),
            'description' => $this->text(),
            'logo' => $this->string(),
            'requisites' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%clinics}}');
    }
}
