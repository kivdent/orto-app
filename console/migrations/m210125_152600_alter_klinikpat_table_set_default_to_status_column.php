<?php

use common\modules\patient\models\Patient;
use yii\db\Migration;

/**
 * Class m210125_152600_alter_klinikpat_table_set_default_to_status_column
 */
class m210125_152600_alter_klinikpat_table_set_default_to_status_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('klinikpat', 'status', $this->string()->defaultValue(Patient::STATUS_ARCHIVE_IN_THE_OFFICE));
        $this->execute('UPDATE klinikpat set status=\''.Patient::STATUS_ARCHIVE_IN_CARD_INDEX.'\' where id>=0');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('klinikpat', 'status', $this->string()->defaultValue(Patient::STATUS_ARCHIVE_IN_THE_OFFICE));
        $this->execute('UPDATE klinikpat set status=NULL where id>=0');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210125_152600_alter_klinikpat_table_set_default_to_status_column cannot be reverted.\n";

        return false;
    }
    */
}
