<?php

use yii\db\Migration;

/**
 * Class m221002_083500_alter_table_nazn_add_column_status
 */
class m221002_083500_alter_table_nazn_add_column_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%nazn}}', 'status', $this->string()->defaultValue(\common\modules\schedule\models\Appointment::STATUS_ACTIVE));
        $this->createIndex('idx_nazn_status',
                'nazn',
                'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx_nazn_status','nazn');
        $this->dropColumn('{{%nazn}}', 'status');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221002_083500_alter_table_nazn_add_column_status cannot be reverted.\n";

        return false;
    }
    */
}
