<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%images}}`.
 */
class m200201_054313_create_images_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%images}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer(),
            'patient_id' => $this->integer(),
            'description' => $this->text(),
            'file_name' => $this->string(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%images}}');
    }
}
