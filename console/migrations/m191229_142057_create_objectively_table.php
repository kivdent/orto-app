<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%objectively}}`.
 */
class m191229_142057_create_objectively_table extends Migration
{
    /**
     * {@inheritdoc}
     */

    const TABLE_NAME = '{{%objectively}}';

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->bigPrimaryKey(),

            'name' => $this->string(60)->notNull(),

            'text' => $this->text(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}