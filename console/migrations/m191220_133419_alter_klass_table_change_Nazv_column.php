<?php

use yii\db\Migration;

/**
 * Class m191220_133419_alter_klass_table_change_Nazv_column
 */
class m191220_133419_alter_klass_table_change_Nazv_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand(' ALTER TABLE `klass` CHANGE COLUMN `Nazv` `Nazv` VARCHAR(500) NOT NULL DEFAULT \'\'')->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191220_133419_alter_klass_table_change_Nazv_column cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191220_133419_alter_klass_table_change_Nazv_column cannot be reverted.\n";

        return false;
    }
    */
}
