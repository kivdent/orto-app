<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%storage_location}}`.
 */
class m210226_120607_create_storage_location_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%storage_location}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'employee_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%storage_location}}');
    }
}
