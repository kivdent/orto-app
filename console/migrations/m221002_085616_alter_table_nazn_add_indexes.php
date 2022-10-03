<?php

use yii\db\Migration;

/**
 * Class m221002_085616_alter_table_nazn_add_indexes
 */
class m221002_085616_alter_table_nazn_add_indexes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('idx_nazn_dayPR',
            'nazn',
            'dayPR');
        $this->createIndex('idx_nazn_NachNaz',
            'nazn',
            'NachNaz');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx_nazn_dayPR','nazn');
        $this->dropIndex('idx_nazn_NachNaz','nazn');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221002_085616_alter_table_nazn_add_indexes cannot be reverted.\n";

        return false;
    }
    */
}
