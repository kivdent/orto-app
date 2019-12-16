<?php

use yii\db\Migration;

/**
 * Class m191212_041629_alter_table_addresses_change_default_value
 */
class m191212_041629_alter_table_addresses_change_default_value extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%addresses}}', 'postcode', $this->integer()->null());
        $this->alterColumn('{{%addresses}}', 'street', $this->string(100)->null());
        $this->alterColumn('{{%addresses}}', 'house', $this->string(20)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191212_041629_alter_table_addresses_change_default_value cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191212_041629_alter_table_addresses_change_default_value cannot be reverted.\n";

        return false;
    }
    */
}
