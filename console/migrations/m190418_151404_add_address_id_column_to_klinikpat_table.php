<?php

use yii\db\Migration;

/**
 * Handles adding address_id to table `{{%klinikpat}}`.
 */
class m190418_151404_add_address_id_column_to_klinikpat_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%klinikpat}}', 'address_id', $this->integer());
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%klinikpat}}', 'address_id');
        
    }
}
