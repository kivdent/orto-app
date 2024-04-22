<?php
/* @var $this yii\web\View */
\common\modules\notifier\assets\NotifierAsset::register($this);
?>
<h1>wazzup/index</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>
<button id="add_user">add user</button>
<?=\yii\helpers\Html::a('Добавить пользователя','wazzup/add-user');?>



    <iframe src="" allow="microphone *; clipboard-write *" id="wazzup_frame"  height="500px" width="100%"></iframe>
