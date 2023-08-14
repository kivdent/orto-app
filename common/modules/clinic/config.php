<?php
/**
 * clinic
 */
return [
    'params' => [
    
         'entities' => [
            'clinic' => 'common\modules\clinic\models\clinic',
            'user'=> 'common\models\User',
             'addresses'=>'common\modules\userInterface\models\addresses',
             'requisites'=>'common\modules\userInterface\models\Requisites',
        ],
        'menuItems' => [
          ['label' => 'Просмотр сведений о клинике', 'url' => '/clinic/manage/index','roles'=>['admin', 'director', ]],
          ['label' => 'Настройки', 'url' => '/clinic/settings/index','roles'=>['admin', 'director', ]],
       //   ['label' => 'Просмотр сведений о клинике', 'url' => '/clinic/financial-divisions','roles'=>['admin', 'director', ]],
        ],
        'moduleMenu' => [
            'file'=>'@common/modules/clinic/components/ModuleMenu.php',
            'forRouts'=>[

            ]
        ],
    ],
];
