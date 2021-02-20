<?php

use yii\db\Migration;

/**
 * Class m210220_105519_alter_table_oplata_add_idx
 */
class m210220_105519_alter_table_oplata_add_idx extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `oplata` 
CHANGE COLUMN `date` `date` DATE NOT NULL DEFAULT '1970-01-01' ");
        $this->createIndex('idx-oplata-dnev', 'oplata', 'dnev');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropIndex('idx-oplata-dnev', 'oplata');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210220_105519_alter_table_oplata_add_idx cannot be reverted.\n";

        return false;
    }
    */
}
