<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%incoming_calls}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%sotr}}`
 * - `{{%sotr}}`
 * - `{{%rejection_reasons}}`
 */
class m230326_084036_create_incoming_calls_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('ALTER TABLE sotr ENGINE=InnoDB');
        $this->createTable('{{%incoming_calls}}', [
            'id' => $this->primaryKey()->notNull(),
            'doctor_id' => $this->integer(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'employee_id' => $this->integer()->notNull(),
            'primary_patient' => $this->integer()->notNull(),
            'call_target' => $this->text(),
            'call_result' => $this->string()->notNull(),
            'by_recommendation' => $this->integer(),
            'rejection_reasons_id' => $this->integer()->notNull()
        ]);

        // creates index for column `doctor_id`
        $this->createIndex(
            '{{%idx-incoming_calls-doctor_id}}',
            '{{%incoming_calls}}',
            'doctor_id'
        );

        // add foreign key for table `{{%sotr}}`
        $this->addForeignKey(
            '{{%fk-incoming_calls-doctor_id}}',
            '{{%incoming_calls}}',
            'doctor_id',
            '{{%sotr}}',
            'id',
            'CASCADE'
        );

        // creates index for column `employee_id`
        $this->createIndex(
            '{{%idx-incoming_calls-employee_id}}',
            '{{%incoming_calls}}',
            'employee_id'
        );

        // add foreign key for table `{{%sotr}}`
        $this->addForeignKey(
            '{{%fk-incoming_calls-employee_id}}',
            '{{%incoming_calls}}',
            'employee_id',
            '{{%sotr}}',
            'id',
            'CASCADE'
        );

        // creates index for column `rejection_reasons_id`
        $this->createIndex(
            '{{%idx-incoming_calls-rejection_reasons_id}}',
            '{{%incoming_calls}}',
            'rejection_reasons_id'
        );

        // add foreign key for table `{{%rejection_reasons}}`
        $this->addForeignKey(
            '{{%fk-incoming_calls-rejection_reasons_id}}',
            '{{%incoming_calls}}',
            'rejection_reasons_id',
            '{{%rejection_reasons}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%sotr}}`
        $this->dropForeignKey(
            '{{%fk-incoming_calls-doctor_id}}',
            '{{%incoming_calls}}'
        );

        // drops index for column `doctor_id`
        $this->dropIndex(
            '{{%idx-incoming_calls-doctor_id}}',
            '{{%incoming_calls}}'
        );

        // drops foreign key for table `{{%sotr}}`
        $this->dropForeignKey(
            '{{%fk-incoming_calls-employee_id}}',
            '{{%incoming_calls}}'
        );

        // drops index for column `employee_id`
        $this->dropIndex(
            '{{%idx-incoming_calls-employee_id}}',
            '{{%incoming_calls}}'
        );

        // drops foreign key for table `{{%rejection_reasons}}`
        $this->dropForeignKey(
            '{{%fk-incoming_calls-rejection_reasons_id}}',
            '{{%incoming_calls}}'
        );

        // drops index for column `rejection_reasons_id`
        $this->dropIndex(
            '{{%idx-incoming_calls-rejection_reasons_id}}',
            '{{%incoming_calls}}'
        );

        $this->dropTable('{{%incoming_calls}}');
    }
}
