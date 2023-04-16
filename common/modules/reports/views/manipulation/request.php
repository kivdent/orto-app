<?php

use common\modules\patient\models\Patient;
use common\modules\patient\models\Statistics;
use common\modules\pricelists\models\PricelistItems;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $patients Patient[] */
/* @var $pricelistItems PricelistItems[] */
$this->title = 'Пациенты с манипуляциями';
?>

<h1><?= $this->title ?></h1>
<?= count($patients) ?>
<h2>Манипуляции</h2>

<?php foreach ($pricelistItems as $pricelistItem): ?>
    <?= $pricelistItem->title ?><br>
<?php endforeach; ?>
<h2>Пациенты</h2>
<table class="table">
    <tr>
        <td>
            Номер карты
        </td>
        <td>
            Имя
        </td>
        <td>
            Пародонтологическое обследование
        </td>
        <td>
            Пародонтологическое лечение
        </td>
    </tr>
    <?php foreach ($patients as $patient): ?>
        <?php $stat = new Statistics(($patient->id)); ?>
        <tr>
            <td>
                <?= Html::a($patient->id, ['/patient/manage/update', 'patient_id' => $patient->id], ['target' => '_blank']) ?>
            </td>
            <td>
                <?= $patient->fullName ?>
            </td>
            <td>
                <?= $stat->FPDate ?>
            </td>
            <td>
                <?= $stat->getVectorDate() ?>
            </td>
        </tr>

    <?php endforeach; ?>
</table>
