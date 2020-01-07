<?php
use kartik\tree\TreeView;
use common\modules\catalogs\models\Prescriptions;
use common\assets\FontAwesomeAsset;


FontAwesomeAsset::register($this);
/* @var $this yii\web\View */
$this->title="Справочник Назначения";
?>
<h1><?= $this->title?></h1>
<?php
echo TreeView::widget([
    'query' => Prescriptions::find()->addOrderBy('root, lft'),
    'headingOptions' => ['label' => 'Назначения'],
    'rootOptions' => ['label'=>'<span class="text-primary">Назначения</span>'],
    'topRootAsHeading' => true, // this will override the headingOptions
    'fontAwesome' => true,
    'isAdmin' => true,
    'iconEditSettings'=> [
        'show' => 'text',
    ],
    'softDelete' => true,
    'cacheSettings' => ['enableCache' => true]
]);
?>
