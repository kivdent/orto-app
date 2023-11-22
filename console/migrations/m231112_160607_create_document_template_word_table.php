<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%document_template_word}}`.
 */
class m231112_160607_create_document_template_word_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%document_template_word}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'file_name' => $this->string(),
            'description' => $this->text(),
            'variables' => $this->string(),
            'employee_id' => $this->integer(),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%document_template_word}}');
    }
}
