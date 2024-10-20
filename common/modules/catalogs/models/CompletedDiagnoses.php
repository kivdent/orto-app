<?php

namespace common\modules\catalogs\models;

use \common\modules\catalogs\models\CompletedDiagnosesForManipulations;
use yii\db\ActiveQuery;

/**
 *
 * @property-read \common\modules\catalogs\models\CompletedDiagnosesForManipulations[] $completedDiagnosesForManipulations
 */
class CompletedDiagnoses extends \common\models\CompletedDiagnoses
{
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'speciality' => 'Специальность',
        ];
    }

    /**
     * @return CompletedDiagnosesForManipulations|ActiveQuery
     */
    public function getCompletedDiagnosesForManipulations():ActiveQuery
    {
        return $this->hasMany(CompletedDiagnosesForManipulations::className(), ['completed_diagnoses_id' => 'id']);
    }
}