<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%completed_diagnoses}}`.
 */
class m241018_091932_create_completed_diagnoses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%completed_diagnoses}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'speciality' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%completed_diagnoses}}');
    }
}
