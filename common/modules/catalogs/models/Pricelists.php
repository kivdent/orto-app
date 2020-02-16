<?php


namespace common\modules\catalogs\models;


use yii\helpers\ArrayHelper;
use common\modules\catalogs\models\Manipulations;
use Yii;

class Pricelists extends \common\models\Pricelists
{
    public $rolesArray = [];
    const SERIALIZE_ALL = 'a:12:{i:0;s:10:"accountant";i:1;s:5:"admin";i:2;s:8:"director";i:3;s:6:"doctor";i:4;s:12:"orthodontist";i:5;s:11:"orthopedist";i:6;s:11:"radiologist";i:7;s:8:"recorder";i:8;s:12:"senior_nurse";i:9;s:7:"surgeon";i:10;s:9:"therapist";i:11;s:4:"user";}
';

    public static function getListOfPricelists(array $ids = null)
    {
        if ($ids == null) {
            $list = self::find()->all();
            // $list = ArrayHelper::map($list, 'id', 'preysk');
        } else {
            $list = self::find()->where(['id' => $ids])->all();
        }

        return $list;
    }

    public function getCategoryes()
    {

        return Manipulations::find()->where(['preysk' => $this->id, 'cat' => 1])->all();
    }

    public function canShownUser($userId)
    {
        $rolesForUser = ArrayHelper::map(Yii::$app->authManager->getRolesByUser($userId), 'name', 'name');

        $result = array_intersect($this->rolesArray, $rolesForUser);
       // print_r($this->rolesArray);

        return $result;
    }

    public function afterFind()
    {
        $this->rolesArray=$this->roles!==null?$this->rolesArray = unserialize($this->roles):array_keys(ArrayHelper::getColumn(Yii::$app->authManager->getRoles(), 'name'));
        return true;
    }
}