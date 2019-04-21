<?php

use yii\db\Migration;

/**
 * Class m190420_063403_alter_klinkpat_table_set_email_type
 */
class m190420_063403_alter_klinkpat_table_set_email_type extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->alterColumn('klinikpat', 'email', $this->string(50));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        echo "m190420_063403_alter_klinikpat_table_set_email_type cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m190420_063403_alter_klinkpat_table_set_email_type cannot be reverted.\n";

      return false;
      }
     */
}
