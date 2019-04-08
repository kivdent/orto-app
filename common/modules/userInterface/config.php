<?php

return [
    'params' => [
        // список параметров
        /**
         * workModuleInterface который, должны реулизовывать рабочие модули
         */
        'workModuleInterface'=>'common\interfaces\WorkModuleInterface',
        /**
         * defaultRoutes маршруты по умолчанию,для разных ролей пользователей 
         */
        'defaultRoutes' => [
            'admin' => '/user/',
            'therapist' => '/old_app/pat_tooday.php',
            'orthopedist'=>'/old_app/pat_tooday.php',
             'surgeon'=>'/old_app/pat_tooday.php',
            'orthodontist'=>'/old_app/pat_tooday.php',
            'recorder'=>'/old_app/pat_tooday_reg.php',
            'accountant'=>'/old_app/hello_word.php',
            'senior nurse'=>'/old_app/spr_sotr.php',
            'director'=>'/old_app/dir_den_opl.php',
            'radiologist'=>'/old_app/rentgen.php?type=today'
        ],
    ],
];
