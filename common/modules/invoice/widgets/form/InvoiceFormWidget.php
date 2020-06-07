<?php

namespace common\modules\invoice\widgets\form;

use common\modules\catalogs\models\Pricelists;
use common\modules\employee\models\Employee;
use common\modules\invoice\models\Invoice;
use common\modules\pricelists\models\Pricelist;
use common\modules\patient\models\Patient;
use common\modules\pricelists\widgets\PriceListsWidget;
use kartik\date\DatePicker;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class InvoiceFormWidget extends \yii\base\Widget
{
    const TYPE_SIMPLE = 'simple';
    const TYPE_PAGE_INVOICE = 'page_invoice';
    const TYPE_PAGE_TECHNICAL_ORDER = 'technical order';
    const TYPE_MODAL_CALCULATOR = 'modal';
    const TYPE_ACTIVE_FORM = 'active_form';

    public $typePriceList;
    public $priceListIds = null;
    public $roles = null;
    public $type = self::TYPE_SIMPLE;
    public $employee_choice;
    public $id = 'invoice_form';
    public $patient_id;
    public $appointment_id;
    public $invoice_type = Invoice::TYPE_MANIPULATIONS;


    public function run()
    {
        $this->setTypePriceList();

        return $this->render('_form', [

            'beforeHtml' => $this->getBeforeHtml(),
            'afterHtml' => $this->getAfterHTML(),
            'typePriceList' => $this->typePriceList,
            'employee_choice' => $this->employee_choice,
        ]);
    }

    public function setTypePriceList()
    {
        if ($this->typePriceList == null) {
            $this->typePriceList = array_key_exists($this->invoice_type, Pricelist::getTypeList()) ? $this->invoice_type : PriceListsWidget::TYPE_PRICELIST_ALL;
        }
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
            case self::TYPE_MODAL_CALCULATOR:
                $html = '
                                    <!-- Modal -->
                    <div class="modal fade" id="' . $this->getIdName() . '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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

            case self::TYPE_PAGE_INVOICE:
                $patient = Patient::findOne($this->patient_id)->getFullName();
                $html = '<h4>Пациент ' . $patient . '</h4>';
                $html .= '<h4 >Счёт за услуги. 
                            <button type="button" class="btn btn-primary submit-invoice">Сохранить</button> 
                            <button type="button" class="btn btn-danger clear-modal" >Очистить</button> 
                           </h4>';
                $html .= Html::input('hidden', 'patient_id', $this->patient_id, ['id' => 'patient_id']);
                $html .= Html::input('hidden', 'appointment_id', $this->appointment_id, ['id' => 'appointment_id']);
                $html .= Html::input('hidden', 'invoice_type', $this->invoice_type, ['id' => 'invoice_type']);
                if ($this->employee_choice) {
                    Врач:
                    $html .= Html::dropDownList('doctor_id', '', Employee::getNursesList(), ['id' => 'doctor_id']);
                } else {
                    $html .= Html::input('hidden', 'doctor_id', Yii::$app->user->identity->employe_id, ['id' => 'doctor_id']);
                }
                break;

            case self::TYPE_PAGE_TECHNICAL_ORDER:
                $patient = Patient::findOne($this->patient_id)->getFullName();
                $html = '<h4>Пациент ' . $patient . '</h4>';
                $html .= '<h4 >Создание заказ-наряда 
                            <button type="button" class="btn btn-primary submit-invoice">Сохранить</button> 
                            <button type="button" class="btn btn-danger clear-modal" >Очистить</button> 
                           </h4>';
                $html .= Html::input('hidden', 'patient_id', $this->patient_id, ['id' => 'patient_id']);
                $html .= Html::input('hidden', 'appointment_id', $this->appointment_id, ['id' => 'appointment_id']);
                $html .= Html::input('hidden', 'invoice_type', $this->invoice_type, ['id' => 'invoice_type']);
                $html .= Html::input('hidden', 'invoice_id', Yii::$app->request->get('invoice_id'), ['id' => 'invoice_id']);
                if ($this->employee_choice) {
                    $html .= 'Врач:' . Html::dropDownList('doctor_id', '', Employee::getNursesList(), ['id' => 'doctor_id']);
                } else {
                    $html .= Html::input('hidden', 'doctor_id', Yii::$app->user->identity->employe_id, ['id' => 'doctor_id']);
                }
                $html .= 'Техник: ' . Html::dropDownList('doctor_id', '', Employee::getTechniciansList(), ['id' => 'technicians_id']) . '<br>';
                $html .= 'Дата сдачи: ';
                $html .= DatePicker::widget([
                    'name' => 'date_picker',
                    'type' => DatePicker::TYPE_INPUT,
                    'value' => date('Y-m-d'),
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                    ],
                    'options' => [
                        'id' => 'date_picker',
                    ],
                ]);

                break;

            default:
                $html = '';
                break;
        }
        return $html;
    }

    private
    function getAfterHTML()
    {
        $html = '';
        switch ($this->type) {
            case self::TYPE_MODAL_CALCULATOR:
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
            default:
                $html = '';
                break;
        }
        return $html;
    }

    public
    function getIdName()
    {
        $id = $this->id;

        return $id;
    }

    public
    static function getInvoiceTable($invoice_id)
    {
        $invoice = Invoice::findOne($invoice_id);
        $html = '<table class="table table-bordered">';
        $html .= '<caption>Счёт за услуги:</caption>
                <thead>
                <tr>
                    <th>#</th>
                    <th>Наименование</th>
                    <th>Цена</th>
                    <th>Количество</th>
                    <th>Стоимость</th>
                    
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th class="text-right">Итого</th>
                    <th id="summary">' . $invoice->amount_payable . ' р.</th>                   
                </tr>
                </tfoot>
                <tbody>';
        $html .= self::getRows($invoice);

        $html .= '</tbody>
</table>';
        return $html;
    }

    public
    static function getRows($invoice)
    {
        $html = '';
        switch ($invoice->type) {
            case Invoice::TYPE_ORTHODONTICS:
                $html .= '<tr>
                    <td>1</td>
                    <td>Оплата за ортодонтическое лечение</td>
                    <td>' . $invoice->amount_payable . ' р.</td>
                    <td>1</td>
                    <td>' . $invoice->amount_payable . ' р.</td>
                    
                </tr>';
                break;
            case Invoice::TYPE_PREPAYMENT:
                $html .= '<tr>
                    <td>1</td>
                    <td>Внесение аванса</td>
                    <td>' . $invoice->amount_payable . ' р.</td>
                    <td>1</td>
                    <td>' . $invoice->amount_payable . ' р.</td>
                    
                </tr>';
                break;
            default:
                $i = 1;
                foreach ($invoice->invoiceItems as $invoiceItem) {
                    $html .= '<tr>
                    <td>' . $i . '</td>
                    <td>' . $invoiceItem->prices->pricelistItems->title . '</td>
                    <td>' . $invoiceItem->prices->price . ' р.</td>
                    <td>' . $invoiceItem->quantity . '</td>
                    <td>' . $invoiceItem->summary . ' р.</td>
                    
                </tr>';
                    $i++;
                }
                break;
        }
        return $html;
    }
}