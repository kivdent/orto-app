<?php

use yii\db\Migration;

/**
 * Class m190319_152742_alter_table_usersprava_add_column_new_user_id
 */
class m190319_152742_alter_table_usersprava_add_column_new_user_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('usersprava', 'new_user_id', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('usersprava', 'new_user_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190319_152742_alter_table_usersprava_add_column_new_user_id cannot be reverted.\n";

        return false;
    }
    */
}
