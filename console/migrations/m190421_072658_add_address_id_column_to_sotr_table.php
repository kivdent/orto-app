<?php

use yii\db\Migration;


/**
 * Handles adding address_id to table `{{%sotr}}`.
 */
class m190421_072658_add_address_id_column_to_sotr_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->alterColumn('{{%sotr}}', 'dr', $this->date()->null());
        $this->addColumn('{{%sotr}}', 'address_id', $this->integer());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%sotr}}', 'address_id');
        $this->alterColumn('{{%sotr}}', 'dr', $this->date()->notNull());

    }
}
