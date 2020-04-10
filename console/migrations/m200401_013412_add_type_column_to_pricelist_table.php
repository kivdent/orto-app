<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%pricelist}}`.
 */
class m200401_013412_add_type_column_to_pricelist_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%pricelist}}', 'type', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%pricelist}}', 'type');
    }
}
