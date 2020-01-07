<?php


namespace common\modules\catalogs\models;


use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class ObjectivelyItems extends \common\models\ObjectivelyItems
{
    const OBJECTEVLY_ITEM_TYPE_TEXT = 'text';
    const OBJECTEVLY_ITEM_TYPE_LIST = 'list';
    const OBJECTEVLY_ITEM_TYPE_LIST_MULTIPLE = 'list_multiple';

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
            $subItemsListModified[" ".$item]=$item;
        }
        return $subItemsListModified;
    }

    public function getElement()
    {
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
    public function getListName(){
        return 'list-'.$this->id;
    }

    public function list_multipleElement()
    {
        $element = '';
        $element .= Html::dropDownList($this->getMultipleListName(), '', $this->getSubItemsList(), [
            'multiple' => 'multiple',
            'size' => '1',
            'id'=>$this->getMultipleListName(),
            'class'=>'objectively-multiple',
        ]);
        return $element;

    }

    public function getMultipleListName(){
        return 'multiple-list-'.$this->id;
    }

    public function getString()
    {

        $string = call_user_func([$this, $this->type . 'String']);
        return $string;
    }

    public function textString()
    {
        $string = '';
        foreach ($this->subItems as $subItem) {
            $string .= '"'.$subItem->value . ' " ';
        }
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
}