<?php


namespace frontend\controllers;
use yii\web\Controller;

class DiskController extends Controller
{
public function actionIndex()
{
    return $this->render('index');
}
}