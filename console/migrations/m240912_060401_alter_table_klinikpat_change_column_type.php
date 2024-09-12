<?php

use yii\db\Migration;

/**
 * Class m240912_060401_alter_table_klinikpat_change_column_type
 */
class m240912_060401_alter_table_klinikpat_change_column_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropIndex('idx_klinikpat_type', 'klinikpat');
        $this->renameColumn('{{%klinikpat}}', 'type','card_type');
        $this->createIndex('idx_klinikpat_card_type', 'klinikpat', 'card_type');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx_klinikpat_card_type', 'klinikpat');
        $this->renameColumn('{{%klinikpat}}', 'card_type','type');
        $this->createIndex('idx_klinikpat_type', 'klinikpat', 'type');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240912_060401_alter_table_klinikpat_change_column_type cannot be reverted.\n";

        return false;
    }
    */
}
