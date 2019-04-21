<?php

use yii\db\Migration;

/**
 * Handles adding adres to table `{{%sotr}}`.
 */
class m190421_092927_add_adres_column_to_sotr_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%sotr}}', 'adres', $this->string()->null());
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%sotr}}', 'adres', $this->string()->notNull());
        
    }
}
