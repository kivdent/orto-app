<?php


namespace common\modules\schedule\models;


use common\modules\employee\models\Employee;

use common\modules\userInterface\models\UserInterface;
use Yii;
use yii\base\Model;
use yii\helpers\Html;

class TimeSheetManager extends Model

{
    public $days = [];
    public $startDate;//timestamp

    public $endDate;
    public $table;

    public function __construct($config = [])
    {
        parent::__construct($config);
        if (!isset($this->startDate)) $this->startDate = strtotime(date('1.m.Y'));
        $this->endDate = strtotime(date('t-m-Y', $this->startDate));
        $this->days = $this->getDays();
        $this->table = $this->getTable();
    }


    private function getDays()
    {
        $days['employee'] = "<small>Сотрудник</small>";
        $days['worked_days'] = "<small>Отработано дней</small>";
        $days['total_time'] = "<small>Отработанное время</small>";
        $days['actions'] ="<small>Действия</small>";
        for ($date = $this->startDate; $date <= $this->endDate; $date += 24 * 60 * 60) {
            $days[date('d.m.Y', $date)] = date('d', $date);
        }
        return $days;
    }

    private function getTable()
    {
        $rows = [];
        foreach (Employee::getList() as $employee_id => $employee_name) {
            $row['employee'] = "<small><strong>" . $employee_name . "</strong></small>";//имя сотрдника

            if (Yii::$app->user->can(UserInterface::PERMISSION_EDIT_SCHEDULE) or UserInterface::getRoleName(Yii::$app->user->id)===UserInterface::ROLE_RECORDER) $row['actions'] = $this->getTimeShitTodayAction($employee_id);

            $worked_days = 0;
            $duration = 0;
            for ($date = $this->startDate; $date <= $this->endDate; $date += 24 * 60 * 60) {

                $timeSheet = TimeSheet::find()
                    ->where(['date' => date('Y-m-d', $date)])
                    ->andWhere(['sotr' => $employee_id])
                    ->one();
                $row[date('d.m.Y', $date)] = "<small>";
                if ($timeSheet) {
                    if (Yii::$app->user->can(UserInterface::PERMISSION_EDIT_SCHEDULE)) $row[date('d.m.Y', $date)] .= Html::a("Изменить",
                            ['update', 'id' => $timeSheet->id],
                            ['class' => 'btn btn-success btn-xs', 'role' => 'button']);
                    $row[date('d.m.Y', $date)] .= $timeSheet->in . "-" . $timeSheet->out;
                    $worked_days++;
                    $duration += $timeSheet->duration;
                    $row[date('d.m.Y', $date)] .= "<br>" . UserInterface::SecondsToHours($timeSheet->duration);

                } else {if (Yii::$app->user->can(UserInterface::PERMISSION_EDIT_SCHEDULE))  $row[date('d.m.Y', $date)] .=Html::a("Создать",
                    ['create', 'date' => $date,'employee_id'=>$employee_id],
                    ['class' => 'btn btn-success btn-xs', 'role' => 'button']);
                    $row[date('d.m.Y', $date)] .= 'Выходной';


                }
                $row[date('d.m.Y', $date)] .= "</small>";
            }
            $row['worked_days'] = $worked_days;
            $row['total_time'] = UserInterface::SecondsToHours($duration);
            $rows[] = $row;
        }
        return $rows;
    }

    private function getTimeShitTodayAction($employee_id)
    {
        $action = '';
        $timeSheet = TimeSheet::find()
            ->where(['sotr' => $employee_id])
            ->andWhere(['date' => date('Y-m-d')])
            ->one();
        if (!$timeSheet) {
            $action .= Html::a("Начало смены",
                ['in', 'employee_id' => $employee_id],
                ['class' => 'btn btn-success btn-xs', 'role' => 'button']);
        } elseif ($timeSheet->out == '00:00:00') {
            $action .= $timeSheet->in . "<br>" . Html::a("Окончние смены",
                    ['out', 'id' => $timeSheet->id],
                    ['class' => 'btn btn-warning btn-xs', 'role' => 'button']);
        } else {
            $action .= Html::a("Изменить",
                ['update', 'id' => $timeSheet->id],
                ['class' => 'btn btn-success btn-xs', 'role' => 'button']). "<br>" .
                $timeSheet->in . "<br>" .
                $timeSheet->out;                ;
        }
        return $action;
    }

}