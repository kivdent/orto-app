<?php

use yii\db\Migration;

/**
 * Class m200513_094425_update_rezobzv
 */
class m200513_094425_update_rezobzv extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('rezobzv', [
            'id'=>7,
            'RezObzv' => 'Отправлено смс',
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $sql = 'DELETE FROM `orto-temp`.`rezobzv`
                        WHERE  `id` = 7,
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
        echo "m200513_094425_update_rezobzv cannot be reverted.\n";

        return false;
    }
    */
}
