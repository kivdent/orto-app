<?php

use yii\db\Migration;

/**
 * Class m190321_041901_alter_teble_drop_index_email
 */
class m190321_041901_alter_teble_drop_index_email extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->dropIndex('email', 'user');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->createIndex('email', 'user', 'email', $unique = true);
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m190321_041901_alter_teble_drop_index_email cannot be reverted.\n";

      return false;
      }
     */
}
