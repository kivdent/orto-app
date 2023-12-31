<?php


namespace common\modules\pricelists\widgets;


use common\modules\pricelists\models\Pricelist;
use common\modules\pricelists\models\PricelistItems;
use yii\base\Widget;

class PriceListsWidget extends Widget
{
    const TYPE_EDIT = 'edit';
    const TYPE_INVOICE = 'invoice';
    const TYPE_COMPLIANCE = 'compliance';
    const ACTIVE_NONE = 'none';
    const TYPE_BATCH_EDITING = 'batch-editing';
    const TYPE_PRICELIST_ALL = 'all';
    const TYPE_INVOICE_STAT = 'invoice_stat';

    public $type = self::TYPE_INVOICE;
    public $activePriceList = self::ACTIVE_NONE;
    public $activeLabel = [0 => '<span class="label label-danger">Не активно</span>',
        1 => ''];
    public $activateBtnClass = [0 => 'btn btn-info btn-xs', 1 => 'btn btn-warning btn-xs'];
    public $typePriceLists = self::TYPE_PRICELIST_ALL;

    public static function getAriaExpanded($type)
    {
        $ariaExpandedString = 'aria-expanded=';
        switch ($type) {
            case self::TYPE_BATCH_EDITING:
                $ariaExpandedString .= '"true"';
                break;
            default:
                $ariaExpandedString .= '"false"';
                break;
        }
        return $ariaExpandedString;
    }

    public static function getCollapseIn($type)
    {
        $collapseInString = '';
        switch ($type) {
            case self::TYPE_BATCH_EDITING:
                $collapseInString .= 'in';
                break;
        }
        return $collapseInString;
    }

    public function run()
    {

        return $this->render('_form', [
            'priceLists' => $this->getListOfPricelist(),
            'type' => $this->type,
            'activePriceList' => $this->activePriceListId,
            'activeLabel' => $this->activeLabel,
            'activateBtnClass' => $this->activateBtnClass,
        ]);
    }

    public function getActivePriceListId()
    {
        $priceList = Pricelist::findOne($this->activePriceList);
        if ($this->activePriceList !== self::ACTIVE_NONE && $priceList !== null) {
            return $priceList->id;
        } else {
            return Pricelist::find()->one()->id;
        }
    }

    public function getListOfPricelist()
    {
        $priceLists = [];
        switch ($this->type) {
            case self::TYPE_INVOICE_STAT:
            case self::TYPE_COMPLIANCE:
            case self::TYPE_EDIT:
                $priceLists = Pricelist::getList();
                break;
            case self::TYPE_BATCH_EDITING:
            case self::TYPE_INVOICE:
                $priceLists = Pricelist::getActiveList($this->typePriceLists);
                break;
        }
        return $priceLists;
    }

    public static function getCategoryes($priceListId, $widgetType)
    {
        $categoryes = [];
        $priceList = Pricelist::findOne($priceListId);
        switch ($widgetType) {

            case self::TYPE_INVOICE_STAT:
            case self::TYPE_EDIT:
                $categoryes = $priceList->getCategoryes();
                break;
            case self::TYPE_COMPLIANCE:
            case self::TYPE_BATCH_EDITING:
            case self::TYPE_INVOICE:
                $categoryes = $priceList->getActiveCategoryes();
                break;
        }

        return $categoryes;
    }

    public static function getItemsFromCategory($categoryId, $widgetType)
    {
        $items = [];
        $category = PricelistItems::findOne($categoryId);
        switch ($widgetType) {
            case self::TYPE_INVOICE_STAT:
            case self::TYPE_EDIT:
                $items = $category->getItemsFromCategory();
                break;
            case self::TYPE_COMPLIANCE:
            case self::TYPE_BATCH_EDITING:
            case self::TYPE_INVOICE:
                $items = $category->getActiveItemsFromCategory();
                break;
        }

        return $items;
    }
}