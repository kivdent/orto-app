<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%base_schedules_types}}`.
 */
class m190422_111019_create_base_schedules_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%base_schedules_types}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'days' => $this->integer(),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%base_schedules_types}}');
    }
}
