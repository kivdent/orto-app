<?php


namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\User;

class RbacController extends Controller
{

    public function actionInit()
    {
        $auth = Yii::$app->authManager;


        // добавляем роль "user" и даём роли разрешение "createPost"
        $user = $auth->createRole('user');
        $user->description="Пользователь";
        $auth->add($user);


        // добавляем роль "doctor" и даём роли разрешение "updatePost"
        // а также все разрешения роли "user"
        $doctor = $auth->createRole('doctor');
        $doctor->description="Врач";
        $auth->add($doctor);
        $auth->addChild($doctor, $user);

        // добавляем роль "recorder" и даём роли разрешение "updatePost"
        // а также все разрешения роли "user"
        $recorder = $auth->createRole('recorder');
        $recorder->description="Регистратор";
        $auth->add($recorder);
        $auth->addChild($recorder, $user);


        // добавляем роль "accountant" и даём роли разрешение "updatePost"
        // а также все разрешения роли "user"
        $accountant = $auth->createRole('accountant');
        $accountant->description="Бухгалтер";
        $auth->add($accountant);
        $auth->addChild($accountant, $user);

        // добавляем роль "senior_nurse" и даём роли разрешение "updatePost"
        // а также все разрешения роли "user"
        $senior_nurse = $auth->createRole('senior_nurse');
        $senior_nurse->description ="Старшая медицинска сестра";
        $auth->add($senior_nurse);
        $auth->addChild($senior_nurse, $user);

        // добавляем роль "director" и даём роли разрешение "updatePost"
        // а также все разрешения роли "user"
        $director = $auth->createRole('director');
        $director->description="Директор";
        $auth->add($director);
        $auth->addChild($director, $user);

        // добавляем роль "radiologist" и даём роли разрешение "updatePost"
        // а также все разрешения роли "user"
        $radiologist = $auth->createRole('radiologist');
        $radiologist->description="Рентгенлаборант";
        $auth->add($radiologist);
        $auth->addChild($radiologist, $user);

        // добавляем роль "orthopedist" и даём роли разрешение "updatePost"
        // а также все разрешения роли "user"
        $orthopedist = $auth->createRole('orthopedist');
        $orthopedist->description="Ортопед";
        $auth->add($orthopedist);
        $auth->addChild($orthopedist, $doctor);

        // добавляем роль "surgeon" и даём роли разрешение "updatePost"
        // а также все разрешения роли "user"
        $surgeon = $auth->createRole('surgeon');
        $surgeon->description="Хирург";
        $auth->add($surgeon);
        $auth->addChild($surgeon, $doctor);

        // добавляем роль "orthodontist" и даём роли разрешение "updatePost"
        // а также все разрешения роли "user"
        $orthodontist = $auth->createRole('orthodontist');
        $orthodontist->description="Ортодонт";
        $auth->add($orthodontist);
        $auth->addChild($orthodontist, $doctor);

        // добавляем роль "therapist" и даём роли разрешение "updatePost"
        // а также все разрешения роли "user"
        $therapist = $auth->createRole('therapist');
        $therapist->description="Терапевт";
        $auth->add($therapist);
        $auth->addChild($therapist, $doctor);

        // добавляем роль "admin" и даём роли разрешение "updatePost"
        // а также все разрешения роли "user"
        $admin = $auth->createRole('admin');
        $admin->description="Администратор";
        $auth->add($admin);
        $auth->addChild($admin, $therapist);


        $user = new User();
        $user->username = "admin";
        $user->email = "default@site.com";
        $user->setPassword('admin');
        $user->generateAuthKey();
        $user->employe_id = '1';
        $user->save(false);

        // Назначение ролей пользователям. 1 и 2 это IDs возвращаемые IdentityInterface::getId()
        // обычно реализуемый в модели User.

        $auth->assign($admin, $user->id);
    }
}