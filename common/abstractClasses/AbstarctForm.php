<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\abstractClasses;

use Yii;

class AbstarctForm {

    public $subForms = [
    [
        'name' =>'',
        'type'=>'',
        ]
    ];
    private $subFormClasses=[
        'patient' =>''
    ];
    public $relations = [
        ['table_link' => 'column_link'],
        ['table_obj' => 'column_obj'],
    ];

    public function __construct() {
        foreach ($this->subFormClasses as $key=>$formClass) {
            $subForm=new $formClass;
        }
    }

    public function delete() {
        
    }

    public function save() {
        
    }

    public static function getById($id) {
        
    }
    
}
