<?php

/**
 * clinic
 */
return [
    'params' => [

        'menuItems' => [
           
            ['label' => 'Сотрудники', 'url' => '/employee/manage/index','roles'=>['admin', 'senior_nurse', 'director','accountant']],
           ],
       // 'moduleMenu' => '@common/modules/clinic/components/moduleMenu.php',
    ],
];