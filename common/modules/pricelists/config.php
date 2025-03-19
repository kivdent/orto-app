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
            //['label' => 'Прейскуранты', 'url' => '/pricelists/manage', 'roles' => ['admin','senior_nurse', ]],
            ['label' => 'Прейскуранты', 'url' => '/pricelists/manage', 'roles' => ['admin','senior_nurse', \common\modules\userInterface\models\UserInterface::ROLE_ACCOUNTANT]],
            ['label' => 'Пакетное редактирование', 'url' => '/pricelists/manage/batch-editing', 'roles' => ['admin','director', ]],
            ['label' => 'Соответствие техническому прайсу', 'url' => '/pricelists/manage/compliance-technical-order', 'roles' => ['admin', ]],

        ],
        //'moduleMenu' => [],
    ],
];
