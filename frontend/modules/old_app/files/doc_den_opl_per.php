<?php

$ThisVU="all";
$this->title="Финансовый отчёт за день (оплаты)"; 
//include("header.php");
//            Код В стиле  MVC       
//Подключение к БД
require_once 'components/Db.php';
Yii::$app->params['old_app_mvc_path']=Yii::getAlias('@frontend/modules/old_app/files/');
//Подключаем контроллер
require_once 'controllers/FinancialReportController.php';
$type='closedInvoice';
$financialReport=new FinancialReportController;
$financialReport->showFRWorkerInPeriod($type,$_SESSION['UserID']);

//Конец кода в стиле MVC
//include("footer.php");
?>