<?php


namespace common\modules\schedule\models;

use common\modules\clinic\models\Workplaces;

/**
 * @property string $title
 ** @property Workplaces $workplace
 */
class AppointmentsDay extends \common\models\AppointmentsDay
{
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->date = date('Y-m-d', strtotime($this->date));
        return true;
    }

    public function getWorkplace()
    {
        return $this->hasOne(Workplaces::className(), ['id' => 'rabmestoID']);
    }

    public function getTitle()
    {
        return $this->vih == 0 ? 'Рабочий' : 'Выходной';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Дата',
            'vih' => 'Выходной',
            'rabmestoID' => 'Рабочее место',
            'Nach' => 'Начало',
            'Okonch' => 'Окончание',
            'TimePat' => 'Время',
            'vrachID' => 'Врач',
        ];
    }
}