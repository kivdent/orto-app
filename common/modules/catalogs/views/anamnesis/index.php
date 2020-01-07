<?php
/* @var $this yii\web\View */

use common\modules\catalogs\models\Complaints;
use kartik\tree\TreeView;
use common\modules\catalogs\models\Anamnesis;
use common\assets\FontAwesomeAsset;


FontAwesomeAsset::register($this);
$this->title="Справочник анамнез";
?>

<h1><?= $this->title?></h1>
<?php
echo TreeView::widget([
    'query' => Anamnesis::find()->addOrderBy('root, lft'),
    'headingOptions' => ['label' => 'Анамнез'],
    'rootOptions' => ['label'=>'<span class="text-primary">Анамнез</span>'],
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
