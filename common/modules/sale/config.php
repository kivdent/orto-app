<?php

/**
 * clinic
 */

use common\modules\invoice\models\Invoice as InvoiceAlias;
use common\modules\patient\models\Patient;

return [
    'params' => [
        //'entities' => [],
        'menuItems' => [
            ['label' => 'Продажа', 'url' => ['/invoice/manage/create', 'patient_id' => Patient::DEFAULT_ID, 'invoice_type' => InvoiceAlias::TYPE_MATERIALS], 'roles' => ['recorder','senior_recorder',]],
            ['label' => 'Оформить подарочный сертификат', 'url' => ['/invoice/manage/create', 'patient_id' => Patient::DEFAULT_ID, 'invoice_type' => InvoiceAlias::TYPE_GIFT_CARDS], 'roles' => ['recorder','senior_recorder',]],
            ['label' => 'Выданные сертификаты', 'url' => '/old_app/certif_gift.php', 'roles' => ['recorder','senior_recorder',]],
            // echo "<a href='/invoice/manage/create?patient_id=".$rowB['13']."&appointment_id=".$rowB[2]."&invoice_type=".Invoice::TYPE_MATERIALS."' class='menu2'>Материалы</a><br>";
            //['label' => 'Подарочные сертификаты', 'url' => '/old_app/certif_gift.php?action=add&step=1', 'roles' => ['recorder',]],
            // ['label' => 'Оформить подарочный сертификаты', 'url' => '/old_app/certif_gift.php?action=add&step=1', 'roles' => ['recorder',]],
            //['label' => 'Продажа гигиены', 'url' => '/old_app/pr_opl_hyg.php', 'roles' => ['recorder',]],

        ],
        //'moduleMenu' => []
    ],
];
