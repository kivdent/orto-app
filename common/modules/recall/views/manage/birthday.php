<?php
/* @var $this yii\web\View */
/* @var $birthdaysTable \common\modules\recall\models\BirthdaysTable*/

use common\widgets\tableWidget\TableWidget;

$this->title='Дни рождения пациентов. '.\common\modules\userInterface\models\UserInterface::getMonthName(date('n'));
?>
<h1><?=$this->title?></h1>
<h2>Всего пациентов: <?=$birthdaysTable->totalPatients?></h2>
<?= TableWidget::widget(['table'=>$birthdaysTable->table,'labels'=>$birthdaysTable->labels])?>