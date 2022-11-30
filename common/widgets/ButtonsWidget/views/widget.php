<?php


/* @var $this \yii\web\View */
/* @var  $buttons string*/
/* @var  $alignment string*/
/* @var  $style string*/
/* @var  $label string*/
/* @var  $buttons_class string*/

use common\widgets\ButtonsWidget\ButtonsWidget;

?>
<?php if ($style== ButtonsWidget::STYLE_GROUP):?>
<div class="<?=$alignment?>" role="group">
    <?=$buttons?>
</div>
<?php else:?>
    <div class="btn-group">
        <button type="button" class="<?=$buttons_class?> dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?=$label?> <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <?=$buttons?>
        </ul>
    </div>
<?php endif;?>
