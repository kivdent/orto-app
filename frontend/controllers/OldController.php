<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\controllers;
use yii\web\Controller;
/**
 * Description of OldController
 *
 * @author kivde
 */
class OldController extends Controller {
    public function actionIndex($file) {
        require_once '@frontend/web/old/'.$file;
    }
}
