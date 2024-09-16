<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%daypr}}`.
 */
class m240916_101535_add_comment_column_to_daypr_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%daypr}}', 'comment', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%daypr}}', 'comment');
    }
}
