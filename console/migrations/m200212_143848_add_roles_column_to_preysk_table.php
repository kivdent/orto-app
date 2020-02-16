<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%preysk}}`.
 */
class m200212_143848_add_roles_column_to_preysk_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%preysk}}', 'roles', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%preysk}}', 'roles');
    }
}
