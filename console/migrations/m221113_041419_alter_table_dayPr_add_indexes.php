<?php

use yii\db\Migration;

/**
 * Class m221113_041419_alter_table_dayPr_add_indexes
 * daypr
 */
class m221113_041419_alter_table_dayPr_add_indexes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('daypr','date',$this->date()->defaultValue('2004-11-21'));
        $this->createIndex('idx-daypr-date', 'daypr', 'date');
        $this->createIndex('idx-daypr-vrachID', 'daypr', 'vrachID');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-daypr-date', 'daypr');
        $this->dropIndex('idx-daypr-vrachID', 'daypr');
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221113_041419_alter_table_dayPr_add_indexes cannot be reverted.\n";

        return false;
    }
    */
}
