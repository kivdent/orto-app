<?php

use yii\db\Migration;

/**
 * Handles adding requisites_id to table `{{%clinics}}`.
 */
class m190413_085923_add_requisites_id_column_to_clinics_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        
        $this->renameColumn('{{%clinics}}', 'requisites', 'requisites_id');
        $this->renameColumn('{{%clinics}}', 'address', 'address_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         $this->renameColumn('{{%clinics}}', 'requisites_id', 'requisites');
          $this->renameColumn('{{%clinics}}', 'address_id', 'address');
    }
}
