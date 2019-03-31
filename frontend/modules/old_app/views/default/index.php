<?php

/* @var $file string */
/* @var $this yii\web\View */

use frontend\modules\old_app\assets\OldAppAsset;
require_once(Yii::getAlias('@frontend/modules/old_app/files/function.php'));
error_reporting(0); //отключение показа всех ошибок
OldAppAsset::register($this);

require_once (Yii::getAlias('@frontend/modules/old_app/files/' . $path));
