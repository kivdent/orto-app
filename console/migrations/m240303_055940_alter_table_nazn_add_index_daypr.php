<?php

use yii\db\Migration;

/**
 * Class m240303_055940_alter_table_nazn_add_index_daypr
 */
class m240303_055940_alter_table_nazn_add_index_daypr extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('idx_nazn_PatID',
            'nazn',
            'PatID');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx_nazn_PatID','nazn');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240303_055940_alter_table_nazn_add_index_daypr cannot be reverted.\n";

        return false;
    }
    */
}
