<?php

use common\modules\userInterface\models\UserInterface;
use yii\db\Migration;

/**
 * Class m210506_063028_add_role_senior_recorder
 */
class m210506_063028_add_role_senior_recorder extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;
        // добавляем разрешение "editSchedule"
        $editSchedule = $auth->createPermission(UserInterface::PERMISSION_EDIT_SCHEDULE);
        $editSchedule->description = 'Изменение расписания';
        $auth->add($editSchedule);
        //присоединения пазрешения  "editSchedule" к ролям

        $senior_nurse=$auth->getRole(UserInterface::ROLE_SENIOR_NURSE);
        $director=$auth->getRole(UserInterface::ROLE_DIRECTOR);
        $admin=$auth->getRole(UserInterface::ROLE_ADMIN);

        $auth->addChild($senior_nurse,$editSchedule);
        $auth->addChild($director,$editSchedule);
        $auth->addChild($admin,$editSchedule);

        // добавляем роль "senior_recorder"
        $recorder=$auth->getRole(UserInterface::ROLE_RECORDER);
        $senior_recorder = $auth->createRole(UserInterface::ROLE_SENIOR_RECORDER);
        $senior_recorder->description="Старший администратор";
        $auth->add($senior_recorder);
        $auth->addChild($senior_recorder, $recorder);
        $auth->addChild($senior_recorder,$editSchedule);




    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "Измените RBAC вручную";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210506_063028_add_role_senior_recorder cannot be reverted.\n";

        return false;
    }
    */
}
