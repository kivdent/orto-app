<?php

/*@var $menuItems array*/

/* @var $this yii\web\View */

/* @var $patient_id yii\web\View */

use common\modules\documents\models\DocumentTemplateWord;
use yii\helpers\Html;

$this->registerJs('
let patient_id=' . $patient_id . ';
');
$this->registerJs(<<<JS
$('#template_save').on('click',function() {
  window.open('/documents/manage/print-word?patient_id='+patient_id+'&template_id='+$('#word_template_chooser').val());
})
JS
)
?>
<div class="row word_template_chooser">
    <div class="col-lg-12">
        <div class="input-group">
            <?= Html::dropDownList(
                'word_template_chooser',
                '',
                DocumentTemplateWord::getTemplateList(),
                [
                    'class' => 'form-control',
                    'id' => 'word_template_chooser'
                ]) ?>
            <span class="input-group-btn">
                <?= Html::button('Сохранить', ['class' => 'btn btn-success input-group', 'id' => 'template_save']) ?>
            </span>
        </div>
    </div>
</div>
