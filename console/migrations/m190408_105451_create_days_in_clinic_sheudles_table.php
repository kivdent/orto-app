<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%days_in_clinic_sheudles}}`.
 */
class m190408_105451_create_days_in_clinic_sheudles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%days_in_clinic_sheudles}}', [
            'id' => $this->primaryKey(),
            'sheudle_id' => $this->integer(),
            'day_number' => $this->integer(),
            'holiday' => $this->boolean(),
            'start' => $this->time(),
            'end' => $this->time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%days_in_clinic_sheudles}}');
    }
}
