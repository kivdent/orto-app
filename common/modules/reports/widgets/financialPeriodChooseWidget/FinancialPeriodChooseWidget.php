<?php


namespace common\modules\reports\widgets\financialPeriodChooseWidget;


use common\modules\reports\models\FinancialPeriods;
use common\modules\userInterface\models\UserInterface;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class FinancialPeriodChooseWidget extends Widget
{
    public $link;
    public $var;
    public $period_month;
    public $period_year;

    function run()
    {
        $this->setParamsToLink();
        if (!isset($this->period_month)){
            $this->period_month=1;
        }
        if (!isset($this->period_year)){
            $this->period_year=date("Y");
        }
        $js = ' $("#period-choose").click(function(){
                    let href="' . $this->link . '";
                    let action="/reports/financial/get-period";
                    let data={
                        "period_month":$("#period_month").val(),
                        "period_year":$("#period_year").val(),
                    };
                    console.log(data);
                    $.ajax({
                        url: action,
                        type: "POST",
                        data: data,
                        success: function (response) {
                            console.log(response);                
                            if (response=="error"){
                                alert("Период не найден");
                            }
                            else{
                                href+=response;
                                window.location=href;
                            }                
                        },
                        error: function () {
                            alert("Период не найден");
                        }
                    });
                 })';

        Yii::$app->controller->view->registerJs($js);
        echo 'Период: ';
        echo Html::dropDownList('period_month', $this->period_month, $this->getMonthList(), ['id' => 'period_month']) . " ";
        echo Html::dropDownList('period_year', $this->period_year, $this->getYearList(), ['id' => 'period_year']) . " ";
        echo Html::button('Выбрать', [
            'class' => 'btn btn-success btn-xs',
            'id' => 'period-choose'
        ]);
    }

    private function getMonthList()
    {
        $list = [];
        $list = UserInterface::getMonthList();
        return $list;
    }

    private function getYearList()
    {
        $list = [];
        $first_period = FinancialPeriods::find()->orderBy(['nach' => SORT_ASC])->one();
        $year = date('Y', strtotime($first_period->nach));

        while ($year <= date('Y')) {
            $list[$year] = $year;
            $year++;
        }
        krsort($list);
        return $list;
    }

    private function setParamsToLink()
    {
        if (isset($this->link)) {
            $this->link = '?';
            foreach (Yii::$app->request->get() as $key => $value) {
                if ($key != $this->var) {
                    $this->link .= $key . '=' . $value . '&';
                }
            }
            $this->link .= $this->var . '=';
        }
    }


}