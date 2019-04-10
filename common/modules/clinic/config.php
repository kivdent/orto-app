<?php
/**
 * clinic
 */
return [
    'params' => [
    
         'entities' => [
            'clinic' => 'common\modules\clinic\models\clinic',
            'user'=> 'common\models\User',
        ],
        'menuItems' => [
          ['label' => 'Просмотр сведений о клинике', 'url' => '/clinic/manage/index','roles'=>['admin', 'director', ]],
        ],
    ],
];
