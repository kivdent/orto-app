<?php
/**
 * This is the model class for table "objectively".
 *
 * @property int $id
 * @property string $name
 * @property string $text
 * @property string $type
 */

namespace common\modules\catalogs\models;


use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Objectively extends \common\models\Objectively


{
    const FORM_NAME_DEFAULT = 'objectivelyForm';
    const  TEXT_AREA_NAME_DEFAULT = 'objectively';

    const TYPE_OBJECTIVELY='objectively';
    const TYPE_THERAPY='therapy';

    public function getObjectivelyItems()
    {
        return $this->hasMany(ObjectivelyItems::className(), ['objectively_id' => 'id']);
    }

    public static function getList($type){
       return ArrayHelper::map(self::find()->where('type=:type',[':type' =>$type] )->asArray()->all(),'id','name');
    }
    public static function getFormName($type){
        return $type."-form";
    }
    public function renderForm($name = null)
    {
        $name=($name===null)?$this->getFormName($this->type):$name;
        $form = '<div id="' . $name . '">';

        foreach ($this->objectivelyItems as $objectivelyItem) {
            $form .= $objectivelyItem->getElement();
        }
        $form .= '</div>';
        return $form;
    }

    public static function renderEmptyForm($type,$name = null)
    {
        $name=($name===null)?self::getFormName($type):$name;
        $form ='<div id="' . $name . '">';
        $form .= '</div>';

        return $form;
    }
    public function renderFormItems()
    {
        $items='';
        foreach ($this->objectivelyItems as $objectivelyItem) {
            $items .= $objectivelyItem->getElement();
        }

        return $items;
    }
    public static function getTextareaName($type){
        return 'medicalrecords-'.$type;
    }
    public static function renderTextarea($type,$textAreaName=null,$rows=6,$cols=35)
    {
        $textAreaName=($textAreaName===null)?self::getTextareaName($type):$textAreaName;

        return Html::textarea($textAreaName, '', [
            'id' => $textAreaName,
            'rows'=>$rows,
            'cols'=>$cols,
            ]);
    }

    public function renderScript($formName =null, $textAreaName=null)
    {
        $formName=($formName===null)?$this->getFormName($this->type):$formName;
        $textAreaName=($textAreaName===null)?$this->getTextareaName($this->type):$textAreaName;
        $script = '';
        $script .= '$(document).ready(function () {';
        $string = "";

        foreach ($this->objectivelyItems as $objectivelyItem) {
            $string .= $objectivelyItem->getString() . '+';
        };
        $string = mb_substr($string, 0, -1);
        $script .= 'let text=' . $string . ';
        $("#' . $formName . '").on("change", function (event, key) {
                $("#' . $textAreaName . '").val(' . $string . ');
            });';
        $script .= '$(".objectively-multiple").mouseover(function(){
        $(".objectively-multiple").attr("size",5);
        });';
        $script .= '$(".objectively-multiple").mouseleave(function(){
        $(".objectively-multiple").attr("size",1);
        });';
        $script .= '});';
        return $script;
    }
    public static function getTypeList(){
        return[
            self::TYPE_OBJECTIVELY=>'Объективно',
            self::TYPE_THERAPY=>'Лечение',
        ];
    }
    public function getTypeName(){
        return $this->typeList[$this->type];
    }

}