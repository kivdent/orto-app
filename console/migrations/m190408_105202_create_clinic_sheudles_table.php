<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%clinic_sheudles}}`.
 */
class m190408_105202_create_clinic_sheudles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%clinic_sheudles}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'clinic_id' => $this->integer()->notNull(),
            'crated_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'start_date' => $this->date()->notNull(),
            'status' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%clinic_sheudles}}');
    }
}
