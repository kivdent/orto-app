<?php
use kartik\tree\TreeView;
use common\modules\catalogs\models\Therapy;
use common\assets\FontAwesomeAsset;
use yii\web\View;

FontAwesomeAsset::register($this);
/* @var $this yii\web\View */
$this->title="Справочник \"Лечение\"";
?>
    <h1><?= $this->title?></h1>
<?php
echo TreeView::widget([
    'query' => Therapy::find()->addOrderBy('root, lft'),
    'headingOptions' => ['label' => 'Лечение'],
    'rootOptions' => ['label'=>'<span class="text-primary">Лечение</span>'],
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