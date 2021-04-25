<?php

namespace common\modules\schedule\models;

use common\modules\clinic\models\Workplaces;
use common\modules\userInterface\models\UserInterface;
use Yii;

/**
 * This is the model class for table "raspis_day".
 *
 * @property int $id
 * @property int $raspis_pack
 * @property int $dayN
 * @property int $rabmestoID
 * @property int $vih
 * @property string $nachPr
 * @property string $okonchPr
 * @property BaseSchedules $baseSchedules
 * @property Workplaces $workplace
 */
class BaseSchedulesDays extends \yii\db\ActiveRecord
{
    const HOLIDAY = 1;
    const WORKDAY = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'raspis_day';
    }

    public static function getAppointmentsDayForDoctor($doctor_id, $date)
    {
        $appointmentsDay=BaseSchedulesDays::find()
            ->where(['dayN' => date('N', $date)])
            ->leftJoin('raspis_pack', 'raspis_pack.id=raspis_day.raspis_pack')
            ->andWhere(['raspis_pack.status' => BaseSchedules::STATUS_ACTIVE])
            ->andWhere(['raspis_pack.doctor_id' => $doctor_id])
            ->andWhere('raspis_pack.start_date<=\''.date('Y-m-d',$date).'\'')
            ->orderBy('raspis_pack.start_date DESC')
            ->one();
        return $appointmentsDay->getAppointmentsDay($date);

    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['raspis_pack', 'dayN', 'rabmestoID', 'vih'], 'integer'],
            [['nachPr', 'okonchPr'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'raspis_pack' => 'Базовое расписание',
            'dayN' => 'День приёма',
            'rabmestoID' => 'Рабочее место',
            'vih' => 'Выходной',
            'nachPr' => 'Начало прёма',
            'okonchPr' => 'Окончание приёма',
        ];
    }

    public static function getHolidayList()
    {
        return [
            self::HOLIDAY => 'Выходной день',
            self::WORKDAY => 'Рабочий день'
        ];
    }

    public function getAppointmentsDay($date)
    {
        $appointmentsDay=AppointmentsDay::find()
            ->where(['date' => date('Y-m-d', $date)])
            ->andWhere(['vrachID'=>$this->baseSchedules->doctor_id])
            ->one();
        if(!isset($appointmentsDay)){
            $appointmentsDay=new AppointmentsDay([
                'vrachID' => $this->baseSchedules->doctor_id,
                'date' => date('Y-m-d', $date),
                'rabmestoID' => $this->rabmestoID,
                'TimePat' => $this->baseSchedules->appointment_duration,
                'vih' =>$this->vih,
                'Okonch' => $this->okonchPr,
                'Nach' => $this->nachPr,

            ]);
        }
        return $appointmentsDay;
    }
    public function getBaseSchedules(){
        return $this->hasOne(BaseSchedules::className(),['id'=>'raspis_pack']);
    }

    public function getWorkplace()
    {
        return $this->hasOne(Workplaces::className(), ['id' => 'rabmestoID']);
    }
}
