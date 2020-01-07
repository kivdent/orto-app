<?php
use kartik\tree\TreeView;
use common\modules\catalogs\models\Complaints;
use common\assets\FontAwesomeAsset;
FontAwesomeAsset::register($this);
/* @var $this yii\web\View */
$this->title="Справочник жалобы";
?>
<h1><?= $this->title?></h1>
<?php
echo TreeView::widget([
    'query' => Complaints::find()->addOrderBy('root, lft'),
    'headingOptions' => ['label' => 'Жалобы'],
    'rootOptions' => ['label'=>'<span class="text-primary">Жалобы</span>'],
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

