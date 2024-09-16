<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%daypr}}`.
 */
class m240916_043707_add_specialization_appointments_day_column_to_daypr_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%daypr}}', 'specialization_appointments_day', $this->string()->defaultValue(\common\modules\schedule\models\AppointmentsDay::SPECIALIZATION_COMMON));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%daypr}}', 'specialization_appointments_day');
    }
}
