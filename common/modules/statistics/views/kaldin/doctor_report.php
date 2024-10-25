<?php

/* @var $this yii\web\View */
/* @var $report KaldinReport */
/* @var $startDate string */
/* @var $period int */

/* @var $doctor_id int */

use common\modules\statistics\models\KaldinReport;
use yii\helpers\Html;

$this->title = 'Отчёт по кальдину для врача ' . $report->doctor->fullName;
?>
<h1><?= $this->title ?></h1>

<div>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#appointments" aria-controls="appointments" role="tab"
                                                  data-toggle="tab">Назначения</a></li>
        <li role="presentation"><a href="#manipulation" aria-controls="manipulation" role="tab" data-toggle="tab">Манипуляции</a>
        </li>
        <li role="presentation"><a href="#completeness" aria-controls="completeness" role="tab" data-toggle="tab">Полнота</a></li>

    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="appointments">
            <table class="table table-bordered" id="table_appointment">
                <tr>
                    <td>Пациент</td>
                    <td>Дата назначения</td>
                    <td>Время назначения</td>
                    <td>Продолжительность приёма</td>
                    <td>Содержание назначения</td>
                    <td>Первичный</td>
                </tr>
                <?php foreach ($report->appointments as $appointment): ?>
                    <tr>
                        <td><?= Html::a($appointment->patient->fullName, ['/patient/manage/update', 'patient_id' => $appointment->patient->id], ['target' => '_blanc']) ?></td>
                        <td><?= $appointment->appointments_day->date ?></td>
                        <td><?= $appointment->NachNaz ?>-<?= $appointment->OkonchNaz ?></td>
                        <td><?= round($appointment->durationSeconds / 60, 2) ?> мин</td>
                        <td><?= $appointment->appointment_content ?></td>
                        <td><?= $appointment->initialDateFlag ? 'Первичный' : 'Повторный' ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <div role="tabpanel" class="tab-pane" id="manipulation">
            <table class="table table-bordered" id="table_manipulation">
                <tr>
                    <td>Манипуляция</td>
                    <td>Количество</td>
                </tr>
                <?php foreach ($report->pricelistItems as $pricelistItem): ?>
                    <td><?= $pricelistItem['title'] ?></td>
                    <td><?= $pricelistItem['count'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <div role="tabpanel" class="tab-pane" id="completeness">
            Полнота: <?=$report->completeness?>
            <table class="table table-bordered" id="table_volume">
                <tr>
                    <th>Диагноз</th>
                    <th>Количество</th>
                </tr>
                <?php foreach ($report->completedDiagnoses as $completedDiagnosis_id=>$completedDiagnosis): ?>
                    <tr>
                        <td><?= $completedDiagnosis['title'] ?></td>
                        <td><?= $completedDiagnosis['count'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

    </div>

</div>