<?php

use yii\db\Migration;

/**
 * Class m190414_135219_alter_rabmesto_table_rename_crated_at_column
 */
class m190414_135219_alter_rabmesto_table_rename_crated_at_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%clinic_sheudles}}','crated_at','created_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('{{%clinic_sheudles}}', 'created_at','crated_at');
    }
}
