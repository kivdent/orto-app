<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%requisites}}`.
 */
class m190408_094604_create_requisites_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%requisites}}', [
            'id' => $this->primaryKey(),
            'full_name' => $this->text(),
            'OGRN' => $this->integer()->notNull(),
            'INN' => $this->integer()->notNull(),
            'KPP' => $this->integer(),
            'legal_address' => $this->integer(),
            'OKPO' => $this->integer(),
            'OKVED' => $this->integer(),
            'checking_account' => $this->integer(),
            'correspondent_bank_account' => $this->integer(),
            'BIC' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%requisites}}');
    }
}
