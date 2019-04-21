<?php

use yii\db\Migration;

/**
 * Class m190421_034437_alter_klinilpat_table_set_NULL_for_some_columns
 */
class m190421_034437_alter_klinilpat_table_set_NULL_for_some_columns extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->alterColumn('klinikpat', 'Prim', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->alterColumn('klinikpat', 'Prim', $this->string()->notNull());
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m190421_034437_alter_klinilpat_table_set_NULL_for_some_columns cannot be reverted.\n";

      return false;
      }
     */
}
