<?php

use yii\db\Migration;

/**
 * Class m200603_114342_change_sn_kass_table
 */
class m200603_114342_change_sn_kass_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
$this->execute("UPDATE 
`sn_kass`
SET
`oper` = 1
WHERE `oper` = 0
");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("UPDATE 
`sn_kass`
SET
`oper` = 1
WHERE `oper` = 0
");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200603_114342_change_sn_kass_table cannot be reverted.\n";

        return false;
    }
    */
}
