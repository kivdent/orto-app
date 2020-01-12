<?php

use yii\db\Migration;


/**
 * Class m200112_075043_add_foreign_keys_to_objective_table
 */
class m200112_075043_add_foreign_keys_to_objective_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('objectively_items','objectively_id','bigint');
        $this
            ->createIndex('idx_objectively_sub_Items_objectively_Items_id',
                'objectively_sub_Items',
                'objectively_Items_id');
        $this->addForeignKey(
            'fk_objectively_sub_Items_objectively_Items_id',
            'objectively_sub_Items',
            'objectively_Items_id',
            'objectively_items',
            'id',
            'CASCADE'
        );
        $this->createIndex(
            'idx_objectively_items_objectively_id',
            'objectively_items',
            'objectively_id'
        );
        $this->addForeignKey(
            'fk_objectively_items_objectively_id',
            'objectively_items',
            'objectively_id',
            'objectively',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropForeignKey(
            'fk_objectively_items_objectively_id',
            'objectively_items'
        );
        $this->dropIndex(
            'idx_objectively_items_objectively_id',
            'objectively_items'
        );
        $this->dropForeignKey(
            'fk_objectively_sub_Items_objectively_Items_id',
            'objectively_sub_Items'
        );
        $this->dropIndex(
            'idx_objectively_sub_Items_objectively_Items_id',
            'objectively_sub_Items');
        return true;
    }
}
