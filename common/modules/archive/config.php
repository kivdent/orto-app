<?php

/**
 * archive
 */

use common\modules\archive\models\ArchivePatientSearch;

return [
    'params' => [
        //'entities' => [],
        'menuItems' => [
            ['label' => 'Карты в архив (старые)', 'url' => '/archive/manage/index?type='. ArchivePatientSearch::TYPE_OLD,'roles'=>['admin', 'recorder', 'senior nurse', ]],
            ['label' => 'Карты в архив (пустые)', 'url' => '/archive/manage/index?type='. ArchivePatientSearch::TYPE_EMPTY,'roles'=>['admin', 'recorder', 'senior nurse', ]],
//            ['label' => 'Карты в архив', 'url' => '/archive/manage/index','roles'=>['admin', 'recorder', 'senior nurse', ]],
//            ['label' => 'Переместить а архив', 'url' => '/archive/manage/send-to-archive','roles'=>['admin', 'recorder', 'senior nurse', ]],
//            ['label' => 'Отчёт за день (оплаты)', 'url' => '/archive/manage/change-status','roles'=>['admin', 'recorder', 'senior nurse', ]],
//            ['label' => 'Создание короба', 'url' => '/archive/manage/create-archive-box','roles'=>['admin', 'recorder', 'senior nurse', ]],
        ],
        //'moduleMenu' => []
    ],
];
