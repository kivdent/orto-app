<?php

/**
 * clinic
 */
return [
    'params' => [
        'entities' => [
            'clinic' => 'common\modules\clinic\models\clinic',
            'user' => 'common\models\User',
            'addresses' => 'common\modules\userInterface\models\addresses',
            'requisites' => 'common\modules\userInterface\models\Requisites',
        ],
        'menuItems' => [
            ['label' => 'Прейскуранты', 'url' => '/pricelists/manage', 'roles' => ['admin','senior_nurse', ]],

        ],
        //'moduleMenu' => [],
    ],
];