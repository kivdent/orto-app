<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%potential_for_rate}}`.
 */
class m241020_090923_create_potential_for_rate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%potential_for_rate}}', [
            'id' => $this->primaryKey(),
            'rate_name' => $this->string(),
            'rate_hours' => $this->float(),
            'hour_price' => $this->integer(),
            'load_goal_percent' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%potential_for_rate}}');
    }
}
