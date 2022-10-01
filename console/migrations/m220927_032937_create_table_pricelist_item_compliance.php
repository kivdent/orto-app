<?php

use yii\db\Migration;

/**
 * Class m220927_032937_create_table_pricelist_item_compliance
 */
class m220927_032937_create_table_pricelist_item_compliance extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pricelist_item_compliances}}', [
            'id' => $this->primaryKey(),
            'pricelist_item_id'=>$this->integer(),
            'compliance_item_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
   $this->dropTable('{{%pricelist_item_compliances}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220927_032937_create_table_pricelist_item_compliance cannot be reverted.\n";

        return false;
    }
    */
}
