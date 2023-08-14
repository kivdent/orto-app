<?php

use common\modules\clinic\models\Settings;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model common\modules\clinic\models\Workplaces */
$this->title='Параметры приложения';
?>
<h1><?=$this->title?></h1>
<?=Html::beginForm('/clinic/settings/set','post',['enctype' => 'multipart/form-data'])?>
<div class="row">
    <div class="col-lg-2">
        Логотип:
    </div>
    <div class="col-lg-6">
        <?=Html::fileInput('file','',['class'=>"form-control"])?>
    </div>
    <div class="col-lg-3">
        <?=Html::img(Settings::getLogoUri(),[
            'class'=>'img-responsive',
            'width'=>'200'
        ])?>
    </div>
</div>
<div class="row">
    <div class="col-lg-2">
        СМС:
    </div>
    <div class="col-lg-6">
        <?=Html::input('text','smsApiKey',Settings::getSmsApiKeyValue(),['class'=>"form-control"])?>
    </div>
</div>
<div class="row">
    <div class="col-lg-2">
        Яндекс диск:
    </div>
    <div class="col-lg-6">
        <?=Html::input('text','yandexDiskToken',Settings::getYandexDiskTokenValue(),['class'=>"form-control"])?>
    </div>
</div>
<?=Html::submitButton('Сохранить', ['class' => 'btn btn-success'])?>
<?=Html::endForm()?>
