<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\time\TimePicker;

/* @var $this yii\web\View */
/* @var $model common\modules\clinic\models\DaysInClinicSheudles */
/* @var $form ActiveForm */
/* @var $day common\modules\clinic\models\DaysInClinicSheudles */
$weekDay = Yii::$app->userInterface->getNameDayWeek($day->day_number);
?>
<h4><?= $weekDay ?></h4>



<?=$form->field($day, "[$day->day_number]holiday", [
    'template' => '{label}{input}{hint}{error}',
])->checkbox();
?><br>

<?=$form->field($day, "[$day->day_number]start", [
    'template' => '{label}<br>{input}{hint}{error}',
])->input('time')
?>-<?=$form->field($day, "[$day->day_number]end", [
    'template' => '{label}<br>{input}{hint}{error}',
])->input('time')
?>

<br>

