<?php

use yii\db\Migration;

/**
 * Class m221102_031715_update_table_nazn_create_new_column_appointment_content
 */
class m221102_031715_update_table_nazn_create_new_column_appitment_update extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%nazn}}', 'appointment_content', $this->string());
        $this->createIndex('idx_nazn_appointment_content',
            'nazn',
            'appointment_content');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx_nazn_appointment_content','nazn');
        $this->dropColumn('{{%nazn}}', 'appointment_content');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221102_031715_update_table_nazn_create_new_column_appitment_update cannot be reverted.\n";

        return false;
    }
    */
}
