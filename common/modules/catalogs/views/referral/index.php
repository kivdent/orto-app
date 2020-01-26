<?php
use kartik\tree\TreeView;
use common\modules\documents\models\Referral;
use common\assets\FontAwesomeAsset;
use yii\web\View;

FontAwesomeAsset::register($this);
/* @var $this yii\web\View */
$this->title="Справочник Направления";
?>
<h1><?= $this->title?></h1>
<?php
echo TreeView::widget([
    'query' => Referral::find()->addOrderBy('root, lft'),
    'headingOptions' => ['label' => 'Рекомендации'],
    'rootOptions' => ['label'=>'<span class="text-primary">Направления</span>'],
    'topRootAsHeading' => true, // this will override the headingOptions
    'fontAwesome' => false,
    'isAdmin' => true,
    'iconEditSettings'=> [
        'show' => 'text',
    ],
    'softDelete' => true,
    'cacheSettings' => ['enableCache' => true]
]);
?>
