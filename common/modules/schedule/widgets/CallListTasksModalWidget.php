<?php

namespace common\modules\schedule\widgets;

class CallListTasksModalWidget extends \yii\base\Widget
{
    public $text='Новая задача';
    public $task_id='';
    public $doctor_id='';
    public $patient_id='';
    public $call_list_id='';

    public function run()
    {
        return $this->render('_call_list_tasks', [
            'text' => $this->text,
            'task_id' => $this->task_id,
            'doctor_id' => $this->doctor_id,
            'patient_id' => $this->patient_id,
            'call_list_id' => $this->call_list_id,
        ]);
    }
}