<?php


namespace common\modules\catalogs\models;


use common\modules\catalogs\models\Objectively;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


class ObjectivelyItems extends \common\models\ObjectivelyItems
{
    private $typeObjectively;
    const OBJECTEVLY_ITEM_TYPE_TEXT = 'text';
    const OBJECTEVLY_ITEM_TYPE_LIST = 'list';
    const OBJECTEVLY_ITEM_TYPE_LIST_MULTIPLE = 'list_multiple';
    const OBJECTEVLY_ITEM_TYPE_TEMPLATE = 'template';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['objectively_id'], 'integer'],
            [['objectively_id'], 'safe'],

            [['type'], 'string', 'max' => 25],
        ];
    }

    public static function getTypeList()
    {
        return [
            self::OBJECTEVLY_ITEM_TYPE_TEXT => "Текстовая строка",
            self::OBJECTEVLY_ITEM_TYPE_LIST => "Выбор одной позиции из списка",
            self::OBJECTEVLY_ITEM_TYPE_LIST_MULTIPLE => "Выбор нескольких позиций из списка",
            self::OBJECTEVLY_ITEM_TYPE_TEMPLATE => "Шаблон",
        ];
    }

    public function getSubItems()
    {
        return $this->hasMany(ObjectivelySubItems::className(), ['objectively_Items_id' => 'id']);
    }

    public function getSubItemsList()
    {
        $subItemsList = ArrayHelper::map($this->getSubItems()->asArray()->all(), 'value', 'value');
        $subItemsListModified=[];
        foreach ($subItemsList as $item){
            $value=($item=="_")  ? "":$item;
            $subItemsListModified[" ".$value]=$value;
        }
        return $subItemsListModified;
    }

    public function getElement($typeObjectecly)

    {
        $this->typeObjectively=$typeObjectecly;
        $element = call_user_func([$this, $this->type . 'Element']);
        return $element;
    }

    public function textElement()
    {
        $element = '';
        foreach ($this->subItems as $subItem) {
            $element .= $subItem->value . ' ';
        }
        return $element;
    }

    public function listElement()
    {
        $element = '';
        $element .= Html::dropDownList($this->getListName(), '', $this->getSubItemsList(),[
            'id'=>$this->getListName(),
        ]);
        return $element;
    }

    public function templateElement(){
        $element = '';
        $objectively=$this->getTemplateObject();
        $element=$objectively->renderFormItems($this->typeObjectively);
        return $element;
    }

    public function getListName(){
        return $this->typeObjectively.'-list-'.$this->id;
    }

    public function list_multipleElement()
    {
        $element = '';
        $element .= Html::dropDownList($this->getMultipleListName(), '', $this->getSubItemsList(), [
            'multiple' => 'multiple',
            'size' => '1',
            'id'=>$this->getMultipleListName(),
            'class'=>'objectively-multiple',
            'onmouseover'=>'size:5',
        ]);
        return $element;

    }

    public function getMultipleListName(){
        return $this->typeObjectively.'-multiple-list-'.$this->id;
    }

    public function getString($typeObjectecly)
    {
        $this->typeObjectively=$typeObjectecly;
        $string = call_user_func([$this, $this->type . 'String']);
        return $string;
    }

    public function textString()
    {
        $string = '"';
        foreach ($this->subItems as $subItem) {
            $string .= $subItem->value . ' ';
        }
        $string .= '"';
        return $string;
    }

    public function listString()
    {
        $string = '$("#'.$this->getListName().'").val()+" "';

        return $string;
    }
    public function list_multipleString()
    {
        $string = '$("#'.$this->getMultipleListName().'").val()+" "';
        return $string;
    }
    public function templateString()
    {
        $string = '';
        $objectively=$this->getTemplateObject();

        foreach ($objectively->objectivelyItems as $objectivelyItem) {
            $string .= $objectivelyItem->getString($this->typeObjectively) . '+';
        };
        $string = mb_substr($string, 0, -1);
        return $string;
    }
    private function getTemplateObject(){
        $id=$this->subItems[0]->value;
        $objectively=Objectively::findOne($id);

        return $objectively;
    }

}