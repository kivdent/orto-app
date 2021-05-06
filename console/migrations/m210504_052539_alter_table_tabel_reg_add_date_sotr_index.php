<?php

use yii\db\Migration;

/**
 * Class m210504_052539_alter_table_tabel_reg_add_date_sotr_index
 */
class m210504_052539_alter_table_tabel_reg_add_date_sotr_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('idx-tabel_reg-date', 'tabel_reg', 'date');
        $this->createIndex('idx-tabel_reg-sotr', 'tabel_reg', 'sotr');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-tabel_reg-date', 'tabel_reg');
        $this->dropIndex('idx-tabel_reg-sotr', 'tabel_reg');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210504_052539_alter_table_tabel_reg_add_date_sotr_index cannot be reverted.\n";

        return false;
    }
    */
}
