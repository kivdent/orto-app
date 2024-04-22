<?php

return [
    'params' => [
        /**
         * menu для разных ролей 
         */
        
       
        'menuItems' => [
            ['label' => 'Пользователи', 'url' => '/user/', 'roles'=>['admin',]],
            ['label' => 'Пользователи Wazzup', 'url' => '/user/manage/wazzup-users/', 'roles'=>['admin',]],
        ],
    ],
];
