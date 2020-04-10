<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pricelist_items}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%pricelist}}`
 */
class m200314_095718_create_pricelist_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pricelist_items}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'pricelist_id' => $this->integer(),
            'category' => $this->boolean(),
            'superior_category_id' => $this->integer(),
            'active' => $this->boolean(),
        ]);

        // creates index for column `pricelist_id`
        $this->createIndex(
            '{{%idx-pricelist_items-pricelist_id}}',
            '{{%pricelist_items}}',
            'pricelist_id'
        );

        // add foreign key for table `{{%pricelist}}`
        $this->addForeignKey(
            '{{%fk-pricelist_items-pricelist_id}}',
            '{{%pricelist_items}}',
            'pricelist_id',
            '{{%pricelist}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%pricelist}}`
        $this->dropForeignKey(
            '{{%fk-pricelist_items-pricelist_id}}',
            '{{%pricelist_items}}'
        );

        // drops index for column `pricelist_id`
        $this->dropIndex(
            '{{%idx-pricelist_items-pricelist_id}}',
            '{{%pricelist_items}}'
        );

        $this->dropTable('{{%pricelist_items}}');
    }
}
