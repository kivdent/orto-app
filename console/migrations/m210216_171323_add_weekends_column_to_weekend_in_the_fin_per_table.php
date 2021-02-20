<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%fin-per}}`.
 */
class m210216_171323_add_weekends_column_to_weekend_in_the_fin_per_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //$this->alterColumn('{{%fin-per}}','nach');
        $this->execute("ALTER TABLE `fin-per` 
CHANGE COLUMN `nach` `nach` DATE NOT NULL DEFAULT '1970-02-01' ,
CHANGE COLUMN `okonch` `okonch` DATE NOT NULL DEFAULT '1970-02-01' ");
//        $this->alterColumn('{{%fin-per}}','nach',$this->date()->defaultValue('1970-01-01'));
//        $this->alterColumn('{{%fin-per}}','okonch',$this->date()->defaultValue('1970-01-01'));
        $this->addColumn('{{%fin-per}}', 'weekends', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%fin-per}}', 'weekends');
    }
}
