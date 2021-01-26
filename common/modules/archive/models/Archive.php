<?php


namespace common\modules\archive\models;


use common\modules\patient\models\Patient;
use common\modules\user\models\User;

use common\modules\userInterface\models\UserInterface;
use Throwable;
use Yii;
use yii\base\Model;


class Archive extends Model
{
    public static $columns = [
        'archival_patient_records' => 'patient_id',
        'avans' => 'pat',
        'disc_cards' => 'pat',
        'disp_card' => 'pat',
        'dogovor' => 'pat',
        'images' => 'patient_id',
        'invoice' => 'patient_id',
        'medical_records' => 'patient_id',
        'orto_sh' => 'pat',
        'osmotr' => 'Pat',
        'psr' => 'pat',
        'igv' => 'pat',
        'notes' => 'patient_id',
        'treatment_plan' => 'patient',
        'nazn'=>'PatID'
    ];

    public static function removeDuplicate(Patient $remainablePatient, Patient $removablePatient)
    {
        $transaction = Yii::$app->getDb()->beginTransaction();
        try {
            foreach (self::$columns as $table => $column) {
                $command = Yii::$app->db->createCommand(
                    'UPDATE ' . $table . ' 
                SET ' . $column . '=' . $remainablePatient->id . ' 
                WHERE ' . $column . '=' . $removablePatient->id
                );
                $command->execute();
//            UserInterface::getVar($command->rawSql, false);
            }
            $remainablePatient->Prim .= 'Объединена ' . date('d.m.Y') .
                ' с картой №' . $removablePatient->id .
                '. Сотрудник: ' . Yii::$app->user->identity->employe->fullName;
//        UserInterface::getVar($remainablePatient->Prim, false);

            $removablePatient->delete();
            $remainablePatient->save(false);
            $transaction->commit();
            Yii::$app->session->setFlash('success', 'Карты совмещены');
        } catch (Throwable $e) {
            $transaction->rollBack();
            throw $e;
         }
        return true;
    }
}