<?php

use yii\db\Migration;

/**
 * Class m200607_101524_add_technician_role
 */
class m200607_101524_add_technician_role extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $technician = $auth->createRole('technician');
        $technician->description="Зубной техник";
        $auth->add($technician);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;

        $technician = $auth->getRole('technician');

        $auth->remove($technician);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200607_101524_add_technician_role cannot be reverted.\n";

        return false;
    }
    */
}
