<?php
/* @var $this yii\web\View */
//\common\assets\VueAsset::register($this);
//\common\modules\schedule\assets\VueTestAsset::register($this);
\common\assets\vueNpmAssets\Vue3Asset::register($this);

?>


<div id="plan">
    <new-unit-form></new-unit-form>
    <plan-unit v-for="(unit,index) in units"
               v-bind:title="unit.title"
               v-bind:key="unit.id"
               v-on:remove-unit="units.splice(index, 1)">
    </plan-unit>
</div>