<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%raspis_pack}}`.
 */
class m190422_092600_create_raspis_pack_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%raspis_pack}}','DateD',$this->date()->defaultValue('1970-01-01'));
        $this->addColumn('{{%raspis_pack}}','doctor_id' , $this->integer()->notNull());
        $this->addColumn('{{%raspis_pack}}','created_at' , $this->dateTime());
        $this->addColumn('{{%raspis_pack}}','updated_at' , $this->dateTime());
        $this->addColumn('{{%raspis_pack}}','start_date' , $this->date());
        $this->addColumn('{{%raspis_pack}}','status' , $this->integer()->notNull());
        $this->addColumn('{{%raspis_pack}}','appointment_duration' , $this->integer()->notNull());
        $sql="UPDATE `raspis_pack`
    SET `start_date`=`DateD`,
    	`doctor_id`=`vrachID`,
    	`appointment_duration`=`prodpr`
    	WHERE `id`>0";
        $this->execute($sql);


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {   
        
        $this->dropColumn('{{%raspis_pack}}','doctor_id' );
        $this->dropColumn('{{%raspis_pack}}','created_at' );
        $this->dropColumn('{{%raspis_pack}}','updated_at');
        $this->dropColumn('{{%raspis_pack}}','start_date');
        $this->dropColumn('{{%raspis_pack}}','status');
        $this->dropColumn('{{%raspis_pack}}','appointment_duration');
    }
}
