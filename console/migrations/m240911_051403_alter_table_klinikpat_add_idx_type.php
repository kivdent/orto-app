<?php

use yii\db\Migration;

/**
 * Class m240911_051403_alter_table_klinikpat_add_idx_type
 */
class m240911_051403_alter_table_klinikpat_add_idx_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('idx_klinikpat_type', 'klinikpat', 'type');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx_klinikpat_type', 'klinikpat');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240911_051403_alter_table_klinikpat_add_idx_type cannot be reverted.\n";

        return false;
    }
    */
}
