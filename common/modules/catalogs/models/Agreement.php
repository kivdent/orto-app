<?php


namespace common\modules\catalogs\models;
use common\modules\catalogs\models\Company;
/**
 * Class Agreement
 * @package common\modules\catalogs\models
 * @property Company $company
 */
class Agreement extends \common\models\Agreement
{
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'firm']);
    }
}