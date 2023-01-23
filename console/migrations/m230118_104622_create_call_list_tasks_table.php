<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%call_list_tasks}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%call_list}}`
 */
class m230118_104622_create_call_list_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%call_list_tasks}}', [
            'id' => $this->primaryKey()->notNull(),
            'patient_id' => $this->integer()->notNull(),
            'doctor_id' => $this->integer()->notNull(),
            'appointment_content' => $this->string(),
            'result' => $this->string()->notNull(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'employee_id' => $this->integer()->notNull(),
            'note' => $this->string(),
            'call_list_id' => $this->integer()->notNull(),
            'status' => $this->string()->defaultValue(\common\modules\schedule\models\CallListTasks::TASK_STATUS_ACTIVE),
        ]);

        // creates index for column `call_list_id`
        $this->createIndex(
            '{{%idx-call_list_tasks-call_list_id}}',
            '{{%call_list_tasks}}',
            'call_list_id'
        );

        // add foreign key for table `{{%call_list}}`
        $this->addForeignKey(
            '{{%fk-call_list_tasks-call_list_id}}',
            '{{%call_list_tasks}}',
            'call_list_id',
            '{{%call_list}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%call_list}}`
        $this->dropForeignKey(
            '{{%fk-call_list_tasks-call_list_id}}',
            '{{%call_list_tasks}}'
        );

        // drops index for column `call_list_id`
        $this->dropIndex(
            '{{%idx-call_list_tasks-call_list_id}}',
            '{{%call_list_tasks}}'
        );

        $this->dropTable('{{%call_list_tasks}}');
    }
}
