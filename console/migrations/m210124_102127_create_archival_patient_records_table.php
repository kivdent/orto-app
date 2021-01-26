<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%archival_patient_records}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%archive_boxes}}`
 */
class m210124_102127_create_archival_patient_records_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%archival_patient_records}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'archive_boxes_id' => $this->integer(),
            'patient_id' => $this->double(),
        ]);

        // creates index for column `archive_boxes_id`
        $this->createIndex(
            '{{%idx-archival_patient_records-archive_boxes_id}}',
            '{{%archival_patient_records}}',
            'archive_boxes_id'
        );

        // add foreign key for table `{{%archive_boxes}}`
        $this->addForeignKey(
            '{{%fk-archival_patient_records-archive_boxes_id}}',
            '{{%archival_patient_records}}',
            'archive_boxes_id',
            '{{%archive_boxes}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%archive_boxes}}`
        $this->dropForeignKey(
            '{{%fk-archival_patient_records-archive_boxes_id}}',
            '{{%archival_patient_records}}'
        );

        // drops index for column `archive_boxes_id`
        $this->dropIndex(
            '{{%idx-archival_patient_records-archive_boxes_id}}',
            '{{%archival_patient_records}}'
        );

        $this->dropTable('{{%archival_patient_records}}');
    }
}
