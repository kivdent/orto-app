<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%technical_order}}`.
 */
class m220208_034412_add_comment_column_to_technical_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%technical_order}}',
            'comment',
            $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%technical_order}}', 'comment');
    }
}
