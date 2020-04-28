<?php

use yii\db\Migration;

/**
 * Class m200410_044949_alter_table_clinic_change_columns
 */
class m200410_044949_alter_table_requisites_change_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('requisites', 'OGRN', 'string');
        $this->alterColumn('requisites', 'INN', 'string');
        $this->alterColumn('requisites', 'KPP', 'string');
        $this->alterColumn('requisites', 'OKPO', 'string');
        $this->alterColumn('requisites', 'OKVED', 'string');
        $this->alterColumn('requisites', 'checking_account', 'string');
        $this->alterColumn('requisites', 'BIC', 'string');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;

//        'id' => $this->primaryKey(),
//            'full_name' => $this->text(),
//            'OGRN' => $this->integer()->notNull(),
//            'INN' => $this->integer()->notNull(),
//            'KPP' => $this->integer(),
//            'legal_address' => $this->integer(),
//            'OKPO' => $this->integer(),
//            'OKVED' => $this->integer(),
//            'checking_account' => $this->integer(),
//            'correspondent_bank_account' => $this->integer(),
//            'BIC' => $this->integer(),
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200410_044949_alter_table_clinic_change_columns cannot be reverted.\n";

        return false;
    }
    */
}
