<?php

namespace common\modules\cash\controllers;

use common\modules\cash\models\AccountCash;
use common\modules\cash\models\Cashbox;
use common\modules\catalogs\models\AccountCashType;
use common\modules\clinic\models\FinancialDivisions;
use common\modules\userInterface\models\UserInterface;
use Yii;
use yii\base\Model;

class ManageController extends \yii\web\Controller
{
    public function actionEnd()
    {
        $cashbox = Cashbox::find()->where(['timeO' => '00:00:00'])->orderBy('date DESC')->one();
        if (!$cashbox) {
            Yii::$app->session->setFlash('error', 'Незакрытые кассовые смены отсутствуют');
            return $this->redirect('start');
        }
        $accountCashs = [];
        $financial_divisions_balance = $cashbox->getBalanceFinancialDivisions();
        foreach (FinancialDivisions::getDivisions() as $division) {
            $accountCash = new AccountCash();
            $accountCash->smena = $cashbox->id;
            $accountCash->znak = -1;
            $accountCash->podr = $division->id;
            $accountCash->oper = AccountCashType::TYPE_CASHBOX_END;
            $accountCashs[] = $accountCash;
        }
        if (Model::loadMultiple($accountCashs, Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($accountCashs as $accountCash) {
                    if ($accountCash->validate()) {
                        if ($financial_divisions_balance['table'][$accountCash->podr]['sum'] < $accountCash->summ) {
                            $transaction->rollBack();
                            Yii::$app->session->setFlash('error', 'Нельзя снять больше ' . $financial_divisions_balance['table'][$accountCash->podr]['sum'] . " на " . $financial_divisions_balance['table'][$accountCash->podr]['title']);
                            return $this->render('end', [
                                'accountCashs' => $accountCashs,
                                'financial_divisions_balance' => $financial_divisions_balance,
                            ]);
                        }
                        $cashbox->summ -= $accountCash->summ;
                        $cashbox->save(false);
                        $accountCash->save();
                    } else {
                        $transaction->rollBack();
                        Yii::$app->session->setFlash('error', $accountCash->errors);
                        return $this->render('end', [
                            'accountCashs' => $accountCashs,
                            'financial_divisions_balance' => $financial_divisions_balance,
                        ]);
                    }
                }
                $cashbox->timeO = date('H:s');
                $cashbox->save(false);
                $transaction->commit();
                $this->redirect('/');
            } catch (Throwable $e) {
                Yii::$app->session->setFlash('error', 'Ошибка базы данных');

                $transaction->rollBack();
                throw $e;
            }
        }
        return $this->render('end', [
            'accountCashs' => $accountCashs,
            'financial_divisions_balance' => $financial_divisions_balance,
        ]);
    }

    public function actionIndex()
    {

        return $this->render('index');
    }

    public function actionMoneyIssue()
    {
        $cashbox = Cashbox::getCurrentCashBox();
        $accountCash = new AccountCash();
        $financial_divisions_balance = $cashbox->getBalanceFinancialDivisions();
        $accountCash->smena = $cashbox->id;
        $accountCash->znak = -1;
        if ($accountCash->load(Yii::$app->request->post()) && $accountCash->summ > 0 && $accountCash->validate()) {
            if ($financial_divisions_balance['table'][$accountCash->podr]['sum'] < $accountCash->summ) {
                Yii::$app->session->setFlash('error', 'Нельзя снять больше ' . $financial_divisions_balance['table'][$accountCash->podr]['sum'] . " на " . $financial_divisions_balance['table'][$accountCash->podr]['title']);
                return $this->render('money-issue', [
                    'accountCash' => $accountCash,
                    'cashbox' => $cashbox,
                    'financial_divisions_balance' => $financial_divisions_balance,
                ]);
            }
            $cashbox->summ -= $accountCash->summ;
            $cashbox->save(false);
            $accountCash->save();
            $this->redirect('/');
        }
        return $this->render('money-issue', [
            'accountCash' => $accountCash,
            'cashbox' => $cashbox,
            'financial_divisions_balance' => $financial_divisions_balance,
        ]);
    }

    public function actionStart()
    {
        if (Cashbox::hasUnclosed()) {
            Yii::$app->session->setFlash('error', 'Закончите предыдущую смену.');
            return $this->redirect('end');
        }
        $sum = Cashbox::find()->orderBy('date DESC')->one()->summ;
        $sum = ($sum === null) ? '0' : $sum;
        if (Yii::$app->request->post('validate')) {
            $cashbox = new Cashbox([
                'summ' => $sum,
                'sotr' => Yii::$app->user->identity->employe_id,
                'date' => date('Y-m-d'),
                'timeN' => date('H:i'),
                'timeO' => '00:00:00'
            ]);
            $cashbox->save(false);
            Yii::$app->session->setFlash('success', 'Кассовая смена успешно открыта');
            $this->redirect('/');
        }


        return $this->render('start', ['sum' => $sum]);
    }
}
