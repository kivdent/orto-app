<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%plan_item}}`.
 */
class m191215_161154_create_plan_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%plan_item}}', [
            'id' => $this->primaryKey(),
            'plan_id' => $this->integer(),
            'operation_id' => $this->integer(),
            'region_id' => $this->integer(),
            'comment' => $this->text(),
            'price_from'=>$this->integer(),
            'price_to'=>$this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%plan_item}}');
    }
}
