<?php

use yii\db\Migration;

/**
 * Class m190416_154841_alter_financial_divisions_table_rename_requisites_column
 */
class m190416_154841_alter_financial_divisions_table_rename_requisites_column extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->renameColumn('{{%financial_divisions}}', 'requisites', 'requisites_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->renameColumn('{{%financial_divisions}}', 'requisites_id', 'requisites');
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m190416_154841_alter_financial_divisions_table_rename_requisites_column cannot be reverted.\n";

      return false;
      }
     */
}
