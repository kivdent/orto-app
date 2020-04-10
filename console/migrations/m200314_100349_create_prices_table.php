<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%prices}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%pricelist_items}}`
 */
class m200314_100349_create_prices_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%prices}}', [
            'id' => $this->primaryKey(),
            'pricelist_items_id' => $this->integer(),
            'price' => $this->integer(),
            'coefficient' => $this->float(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'active' => $this->boolean(),
        ]);

        // creates index for column `pricelist_items_id`
        $this->createIndex(
            '{{%idx-prices-pricelist_items_id}}',
            '{{%prices}}',
            'pricelist_items_id'
        );

        // add foreign key for table `{{%pricelist_items}}`
        $this->addForeignKey(
            '{{%fk-prices-pricelist_items_id}}',
            '{{%prices}}',
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
        // drops foreign key for table `{{%pricelist_items}}`
        $this->dropForeignKey(
            '{{%fk-prices-pricelist_items_id}}',
            '{{%prices}}'
        );

        // drops index for column `pricelist_items_id`
        $this->dropIndex(
            '{{%idx-prices-pricelist_items_id}}',
            '{{%prices}}'
        );

        $this->dropTable('{{%prices}}');
    }
}
