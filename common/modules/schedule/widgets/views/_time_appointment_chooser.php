<?php

/* @var $this \yii\web\View */

/* @var $doctor_id int */
/* @var $patient_id int|null */
/* @var $start_date string */

/* @var $duration string */

use kartik\date\DatePicker;
use yii\helpers\Html;

$this->registerJs(<<<JS

        $('#doctor_id').on('change', function () {
             $('.time-appointment-chooser').attr('doctor_ids',$(this).val());
        });
        
        $('#datePicker').on('change',function () {
            let patient_id=$(this).attr('patient_id');
            let doctor_ids=$(this).attr('doctor_ids');
            let start_date=$(this).val();
            let duration=Number($(this).attr('duration'));
            let link='/schedule/appointment?start_date='+start_date+'&doctor_ids='+doctor_ids+'&patient_id='+patient_id+'&duration='+duration;
            document.location.href=link;
         });  
        
        $('#back').on('click',function () {
           
            let patient_id=$(this).attr('patient_id');
            let doctor_ids=$(this).attr('doctor_ids');
            let duration=Number($(this).attr('duration'));
            let start_date=$(this).attr('start_date');
           
            start_date=start_date.split('.');
          
            start_date=new Date(start_date[2],start_date[1]-1,start_date[0]);
             
            start_date.setDate(start_date.getDate() - duration);
            
            let start_date_string=start_date.getDate()+'.'+(start_date.getMonth()+1)+'.'+start_date.getFullYear();
             
            let link='/schedule/appointment?start_date='+start_date_string+'&doctor_ids='+doctor_ids+'&patient_id='+patient_id+'&duration='+duration;
         
            document.location.href=link;
         }); 
        
        $('#forward').on('click',function () {
            
           let patient_id=$(this).attr('patient_id');
            let doctor_ids=$(this).attr('doctor_ids');
            let duration=Number($(this).attr('duration'));
            let start_date=$(this).attr('start_date');
           
            start_date=start_date.split('.');
          
            start_date=new Date(start_date[2],start_date[1]-1,start_date[0]);
           
            start_date.setDate(start_date.getDate() + duration);
            
            let start_date_string=start_date.getDate()+'.'+(start_date.getMonth()+1)+'.'+start_date.getFullYear();
           
            let link='/schedule/appointment?start_date='+start_date_string+'&doctor_ids='+doctor_ids+'&patient_id='+patient_id+'&duration='+duration;
         
           document.location.href=link;
         });
        
JS
);

?>

<div class="input-group">
            <span class="input-group-btn">
       <?= Html::button('<span class="glyphicon glyphicon-triangle-left"></span>',

//           [
//               '/schedule/appointment',
//               'start_date' => $start_date,
//               'patient_id' => $patient_id,
//               'doctor_ids' => $doctor_id,
//               'duration' => $duration,
//           ]

           [
               'class' => 'btn btn-primary time-appointment-chooser',
               'id' => 'back',
               'start_date' => $start_date,
               'patient_id' => $patient_id ? $patient_id : 'null',
               'doctor_ids' => $doctor_id,
               'duration' => $duration,
           ]) ?>
            </span>
    <?=
    DatePicker::widget([
        'name' => 'datePicker',
        'value' => $start_date,
        //'type' => DatePicker::TYPE_BUTTON,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd.mm.yyyy'
        ],
        'removeButton' => false,
        'options' => [
            'id' => 'datePicker',
            'class' => 'form-control time-appointment-chooser',
            'patient_id' => $patient_id ? $patient_id : 'null',
            'doctor_ids' => $doctor_id,
            'start_date' => $start_date,
            'duration' => $duration,
        ]
        //'buttonOptions' =>'btn btn-primary'
    ])
    ?>
    <span class="input-group-btn">
        <?= Html::button(' <span class="glyphicon glyphicon-triangle-right"></span>',

//            [
////                    '/schedule/appointment',
////                'start_date' => date('d.m.Y', strtotime($start_date . ' +' . $duration . ' days')),
////                'patient_id' => $patient_id,
////                'doctor_ids' => $doctor_id,
//            ]

            [
                'class' => 'btn btn-primary time-appointment-chooser',
                'id' => 'forward',
                'start_date' => $start_date,
                'patient_id' => $patient_id ? $patient_id : 'null',
                'doctor_ids' => $doctor_id,
                'duration' => $duration,
            ]) ?>
            </span>
</div>
