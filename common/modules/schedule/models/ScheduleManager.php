<?php


namespace common\modules\schedule\models;


use common\modules\userInterface\models\UserInterface;
use yii\base\Model;

class ScheduleManager extends Model
{
    public $rows;
    public $start_date;
    public $month_name;

    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->setRows();
        $this->month_name = UserInterface::getMonthList()[date('n', $this->start_date)];
    }

    private function setRows()
    {
        $this->rows = [];
        $i = 0;
        $date = strtotime('1.' . date('m.Y', $this->start_date));
        $startDate = date('d.m.Y', $date);
        $endDate = date('d.m.Y', strtotime(date('t.m.Y', $this->start_date) . '+1 day'));
        $j = 1;


        while (date('d.m.Y', $date) != $endDate) {
            $week = [];
            if (date('d', $date) == 1) {
                for ($i = 1; $i < date('N', $date); $i++) {
                    $week[$i] = 'empty';
                }
                for ($i = date('N', $date); $i <= 7; $i++) {
                    $week[$i] = new ScheduleDayManager(['date' => $date]);
                    $date = strtotime(date('d.m.Y', $date) . ' +1 day');
                }
            } elseif ((date('d', $date) == date('t', $date))) {
                $week[$i] = new ScheduleDayManager(['date' => $date]);
                $date = strtotime(date('d.m.Y', $date) . ' +1 day');

            } else {
                for ($i = 1; $i <= 7; $i++) {
                    $week[$i] = new ScheduleDayManager(['date' => $date]);
                    if (date('d', $date) == date('t', $date)) {
                        for ($i = date('N', $date) + 1; $i <= 7; $i++) {
                            $week[$i] = 'empty';
                        }
                        $this->rows[$j] = $week;
                        break 2;
                    }
                    $date = strtotime(date('d.m.Y', $date) . ' +1 day');
                }
            }
            $this->rows[$j] = $week;
            $j++;
        }
    }

    public function isAppointmentDay($days)
    {
        return ($days !== 'empty');
    }

}