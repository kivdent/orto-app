<?php
use kartik\tree\TreeView;
use common\modules\catalogs\models\Recommendations;
use common\assets\FontAwesomeAsset;
use yii\web\View;

FontAwesomeAsset::register($this);
/* @var $this yii\web\View */
$this->title="Справочник Рекомендации";
?>
<h1><?= $this->title?></h1>
<?php
echo TreeView::widget([
    'query' => Recommendations::find()->addOrderBy('root, lft'),
    'headingOptions' => ['label' => 'Рекомендации'],
    'rootOptions' => ['label'=>'<span class="text-primary">Рекомендации</span>'],
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
