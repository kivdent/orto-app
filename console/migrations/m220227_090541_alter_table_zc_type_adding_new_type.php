<?php

use yii\db\Migration;

/**
 * Class m220227_090541_alter_table_zc_type_adding_new_type
 */
class m220227_090541_alter_table_zc_type_adding_new_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('zc_type', ['id' => 5, 'naim' => 'Процент от выручки']);
        $this->update('zc_type',['naim'=>'Процент от баллов за манипуляции'],['id'=>1]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('zc_type', ['id' => 5]);
        $this->update('zc_type',['naim'=>'Процент от выручки'],['id'=>1]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220227_090541_alter_table_zc_type_adding_new_type cannot be reverted.\n";

        return false;
    }
    */
}
