<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%completed_diagnoses_for_manipulations}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%completed_diagnoses}}`
 * - `{{%pricelist_items}}`
 */
class m241018_092142_create_completed_diagnoses_for_manipulations_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%completed_diagnoses_for_manipulations}}', [
            'id' => $this->primaryKey(),
            'completed_diagnoses_id' => $this->integer(),
            'pricelist_items_id' => $this->integer(),

        ]);

        // creates index for column `completed_diagnoses_id`
        $this->createIndex(
            '{{%idx-completed_diagnoses_for_manipulations-completed_diagnoses_id}}',
            '{{%completed_diagnoses_for_manipulations}}',
            'completed_diagnoses_id'
        );

        // add foreign key for table `{{%completed_diagnoses}}`
        $this->addForeignKey(
            '{{%fk-completed_diagnoses_for_manipulations-completed_diagnoses_id}}',
            '{{%completed_diagnoses_for_manipulations}}',
            'completed_diagnoses_id',
            '{{%completed_diagnoses}}',
            'id',
            'CASCADE'
        );

        // creates index for column `pricelist_items_id`
        $this->createIndex(
            '{{%idx-completed_diagnoses_for_manipulations-pricelist_items_id}}',
            '{{%completed_diagnoses_for_manipulations}}',
            'pricelist_items_id'
        );

        // add foreign key for table `{{%pricelist_items}}`
        $this->addForeignKey(
            '{{%fk-completed_diagnoses_for_manipulations-pricelist_items_id}}',
            '{{%completed_diagnoses_for_manipulations}}',
            'pricelist_items_id',
            '{{%pricelist_items}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%completed_diagnoses}}`
        $this->dropForeignKey(
            '{{%fk-completed_diagnoses_for_manipulations-completed_diagnoses_id}}',
            '{{%completed_diagnoses_for_manipulations}}'
        );

        // drops index for column `completed_diagnoses_id`
        $this->dropIndex(
            '{{%idx-completed_diagnoses_for_manipulations-completed_diagnoses_id}}',
            '{{%completed_diagnoses_for_manipulations}}'
        );

        // drops foreign key for table `{{%pricelist_items}}`
        $this->dropForeignKey(
            '{{%fk-completed_diagnoses_for_manipulations-pricelist_items_id}}',
            '{{%completed_diagnoses_for_manipulations}}'
        );

        // drops index for column `pricelist_items_id`
        $this->dropIndex(
            '{{%idx-completed_diagnoses_for_manipulations-pricelist_items_id}}',
            '{{%completed_diagnoses_for_manipulations}}'
        );

        $this->dropTable('{{%completed_diagnoses_for_manipulations}}');
    }
}
