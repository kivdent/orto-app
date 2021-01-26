<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%archive_boxes}}`.
 */
class m210124_090642_create_archive_boxes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%archive_boxes}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%archive_boxes}}');
    }
}
