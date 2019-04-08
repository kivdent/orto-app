<?php

use yii\db\Migration;

/**
 * Handles adding clinic_id to table `{{%rabmesto}}`.
 */
class m190408_104331_add_clinic_id_column_to_rabmesto_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%rabmesto}}', 'clinic_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%rabmesto}}', 'clinic_id');
    }
}
