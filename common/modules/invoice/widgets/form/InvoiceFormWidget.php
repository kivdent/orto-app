<?php

namespace common\modules\invoice\widgets\form;

use common\modules\catalogs\models\Pricelists;
use Yii;
use yii\helpers\ArrayHelper;

class InvoiceFormWidget extends \yii\base\Widget
{
    const TYPE_SIMPLE = 'simple';
    const TYPE_MODAL = 'modal';
    const TYPE_ACTIVE_FORM = 'active_form';

    public $priceListIds = null;
    public $roles = null;
    public $type = self::TYPE_SIMPLE;
    public $id = 'invoice_form';


    public function run()
    {
        return $this->render('_form', [
            'priceLists' => $this->getListOfPricelists(),
            'beforeHtml' => $this->getBeforeHtml(),
            'afterHtml' => $this->getAfterHTML(),
        ]);
    }

    public function getListOfPricelists()
    {
        $priceLists = [];
        $priceListsAll = Pricelists::getListOfPricelists($this->priceListIds);
        foreach ($priceListsAll as $priceList) {
            if ($priceList->canShownUser(Yii::$app->user->getId())) {
                $priceLists[] = $priceList;
            }
        }
        return $priceLists;
    }

    public function init()
    {
        parent::init();
        if ($this->roles !== null) {
            $this->roles = serialize(array_keys(ArrayHelper::getColumn(Yii::$app->authManager->getRoles(), 'name')));
        }
    }

    private function getBeforeHtml()
    {
        $html = '';
        switch ($this->type) {

            case self::TYPE_SIMPLE:
                $html = '';
                break;
            case self::TYPE_MODAL:
                $html = '
                                    <!-- Modal -->
                    <div class="modal fade" id="'.$this->getIdName().'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Калькулятор стоимости 
                            <button type="button" class="btn btn-primary submit-modal" >Сохранить</button> 
                            <button type="button" class="btn btn-danger clear-modal" >Очистить</button> 
                            <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button></h4>
                          </div>
                          <div class="modal-body">
                          <input type="hidden" class="calling_element">
                          
                ';
                break;
            case self::TYPE_ACTIVE_FORM:
                $html = '';
                break;
        }
        return $html;
    }

    private function getAfterHTML()
    {
        $html = '';
        switch ($this->type) {

            case self::TYPE_SIMPLE:
                $html = '';
                break;
            case self::TYPE_MODAL:
                $html = '
                     </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                            <button type="button" class="btn btn-primary submit-modal" >Сохранить</button>
                          </div>
                        </div>
                      </div>
                    </div>
                ';
                break;
            case self::TYPE_ACTIVE_FORM:

                break;
        }
        return $html;
    }

    public function getIdName()
    {
        $id = $this->id;

        return $id;
    }
}