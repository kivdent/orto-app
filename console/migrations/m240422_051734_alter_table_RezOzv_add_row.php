<?php

use yii\db\Migration;

/**
 * Class m240422_051734_alter_table_RezOzv_add_row
 */
class m240422_051734_alter_table_RezOzv_add_row extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('rezobzv', [
            'id'=>8,
            'RezObzv' => 'WhatsApp',
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $sql = 'DELETE FROM `orto-temp`.`rezobzv`
                        WHERE  `id` = 8,
                        ';
        $this->execute($sql);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240422_051734_alter_table_RezOzv_add_row cannot be reverted.\n";

        return false;
    }
    */
}
