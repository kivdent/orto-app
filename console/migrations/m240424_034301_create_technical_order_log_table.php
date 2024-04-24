<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%technical_order_log}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%technical_order}}`
 * - `{{%sotr}}`
 */
class m240424_034301_create_technical_order_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%technical_order_log}}', [
            'id' => $this->primaryKey(),
            'technical_order_id' => $this->integer(),
            'employee_id' => $this->integer(),
            'created_at' => $this->dateTime(),
            'status' => $this->tinyInteger(),
            'comment' => $this->text(),
            'items' => $this->string(),
        ]);

        // creates index for column `technical_order_id`
        $this->createIndex(
            '{{%idx-technical_order_log-technical_order_id}}',
            '{{%technical_order_log}}',
            'technical_order_id'
        );

        // add foreign key for table `{{%technical_order}}`
        $this->addForeignKey(
            '{{%fk-technical_order_log-technical_order_id}}',
            '{{%technical_order_log}}',
            'technical_order_id',
            '{{%technical_order}}',
            'id',
            'CASCADE'
        );

        // creates index for column `employee_id`
        $this->createIndex(
            '{{%idx-technical_order_log-employee_id}}',
            '{{%technical_order_log}}',
            'employee_id'
        );

        // add foreign key for table `{{%sotr}}`
        $this->addForeignKey(
            '{{%fk-technical_order_log-employee_id}}',
            '{{%technical_order_log}}',
            'employee_id',
            '{{%sotr}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%technical_order}}`
        $this->dropForeignKey(
            '{{%fk-technical_order_log-technical_order_id}}',
            '{{%technical_order_log}}'
        );

        // drops index for column `technical_order_id`
        $this->dropIndex(
            '{{%idx-technical_order_log-technical_order_id}}',
            '{{%technical_order_log}}'
        );

        // drops foreign key for table `{{%sotr}}`
        $this->dropForeignKey(
            '{{%fk-technical_order_log-employee_id}}',
            '{{%technical_order_log}}'
        );

        // drops index for column `employee_id`
        $this->dropIndex(
            '{{%idx-technical_order_log-employee_id}}',
            '{{%technical_order_log}}'
        );

        $this->dropTable('{{%technical_order_log}}');
    }
}
