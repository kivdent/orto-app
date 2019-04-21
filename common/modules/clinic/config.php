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
        ],
        'moduleMenu'=>'@common/modules/clinic/components/moduleMenu.php',
    ],
];
