<?php


namespace common\modules\documents\models;


use kartik\tree\models\Tree;

class Referral extends Tree
{
    public static function tableName()
    {
        return 'referral';
    }
}