<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%technical_order}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%invoice}}`
 */
class m200604_043710_create_technical_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%technical_order}}', [
            'id' => $this->primaryKey(),
            'invoice_id' => $this->integer(),
            'employee_id' => $this->integer(),
            'delivery_date' => $this->date(),
            'technical_order_invoice_id' => $this->integer(),
            'completed' => $this->boolean(),
        ]);

        // creates index for column `invoice_id`
        $this->createIndex(
            '{{%idx-technical_order-invoice_id}}',
            '{{%technical_order}}',
            'invoice_id'
        );

        // add foreign key for table `{{%invoice}}`
        $this->addForeignKey(
            '{{%fk-technical_order-invoice_id}}',
            '{{%technical_order}}',
            'invoice_id',
            '{{%invoice}}',
            'id',
            'CASCADE'
        );
        // creates index for column `technical_order_invoice_id`
        $this->createIndex(
            '{{%idx-technical_order-technical_order_invoice_id}}',
            '{{%technical_order}}',
            'technical_order_invoice_id'
        );

        // add foreign key for table `{{%invoice}}`
        $this->addForeignKey(
            '{{%fk-technical_order-technical_order_invoice_id}}',
            '{{%technical_order}}',
            'technical_order_invoice_id',
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
        // drops foreign key for table `{{%invoice}}`
        $this->dropForeignKey(
            '{{%fk-technical_order-invoice_id}}',
            '{{%technical_order}}'
        );

        // drops index for column `invoice_id`
        $this->dropIndex(
            '{{%idx-technical_order-invoice_id}}',
            '{{%technical_order}}'
        );
// drops foreign key for table `{{%invoice}}`
        $this->dropForeignKey(
            '{{%fk-technical_order-technical_order_invoice_id}}',
            '{{%technical_order}}'
        );

        // drops index for column `invoice_id`
        $this->dropIndex(
            '{{%idx-technical_order-technical_order_invoice_id}}',
            '{{%technical_order}}'
        );

        $this->dropTable('{{%technical_order}}');
    }
}
