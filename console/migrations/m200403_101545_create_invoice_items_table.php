<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%invoice_items}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%prices}}`
 * - `{{%invoice}}`
 */
class m200403_101545_create_invoice_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%invoice_items}}', [
            'id' => $this->primaryKey(),
            'prices_id' => $this->integer(),
            'quantity' => $this->integer(),
            'invoice_id' => $this->integer(),
        ]);

        // creates index for column `prices_id`
        $this->createIndex(
            '{{%idx-invoice_items-prices_id}}',
            '{{%invoice_items}}',
            'prices_id'
        );

        // add foreign key for table `{{%prices}}`
        $this->addForeignKey(
            '{{%fk-invoice_items-prices_id}}',
            '{{%invoice_items}}',
            'prices_id',
            '{{%prices}}',
            'id',
            'CASCADE'
        );

        // creates index for column `invoice_id`
        $this->createIndex(
            '{{%idx-invoice_items-invoice_id}}',
            '{{%invoice_items}}',
            'invoice_id'
        );

        // add foreign key for table `{{%invoice}}`
        $this->addForeignKey(
            '{{%fk-invoice_items-invoice_id}}',
            '{{%invoice_items}}',
            'invoice_id',
            '{{%invoice}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%prices}}`
        $this->dropForeignKey(
            '{{%fk-invoice_items-prices_id}}',
            '{{%invoice_items}}'
        );

        // drops index for column `prices_id`
        $this->dropIndex(
            '{{%idx-invoice_items-prices_id}}',
            '{{%invoice_items}}'
        );

        // drops foreign key for table `{{%invoice}}`
        $this->dropForeignKey(
            '{{%fk-invoice_items-invoice_id}}',
            '{{%invoice_items}}'
        );

        // drops index for column `invoice_id`
        $this->dropIndex(
            '{{%idx-invoice_items-invoice_id}}',
            '{{%invoice_items}}'
        );

        $this->dropTable('{{%invoice_items}}');
    }
}
