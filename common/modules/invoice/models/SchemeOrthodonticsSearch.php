<?php

namespace common\modules\invoice\models;

use common\modules\userInterface\models\UserInterface;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\invoice\models\SchemeOrthodontics;

/**
 * SchemeOrthodonticsSearch represents the model behind the search form of `\common\modules\invoice\models\SchemeOrthodontics`.
 */
class SchemeOrthodonticsSearch extends SchemeOrthodontics
{

    const SEARCH_TYPE_ALL = 'all';
    const SEARCH_TYPE_DOCTOR = 'doctor';

    const SCHEME_NOT_PAID_AND_PAID = 'all';

    public $patientFullName;
    public $employeeFullName;
    /**
     * @var mixed|null
     */
    public $searchType = self::SEARCH_TYPE_ALL;

    public $paid = self::SCHEME_NOT_PAID_AND_PAID;

    public static function getPaidList()
    {
        return [
            self::SCHEME_NOT_PAID_AND_PAID => 'Все',
            self::SCHEME_NOT_PAID => 'Не оплаченные',
            self::SCHEME_PAID => 'Оплаченные',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pat', 'sotr', 'per_lech', 'summ', 'summ_month', 'vnes', 'full', 'last_pay_month'], 'integer'],
            [['date'], 'safe'],
            [['patientFullName', 'employeeFullName', 'paid'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    private function setDefaultQuery()
    {
        $query = SchemeOrthodontics::find();
        switch ($this->searchType) {
            case self::SEARCH_TYPE_ALL:
                $query->orderBy('date DESC');
                break;
            case self::SEARCH_TYPE_DOCTOR:
                $query->orderBy('date DESC')
                    ->where(['sotr' => \Yii::$app->user->identity->employe->id]);
                break;
        }
        return $query;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = $this->setDefaultQuery();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->setSort([
            'attributes' => [
                'patientFullName' => [
                    'asc' => ['klinikpat.surname' => SORT_ASC],
                    'desc' => ['klinikpat.surname' => SORT_DESC],
                    'label' => 'Пациент',
                ],
                'date' => [
                    'asc' => ['date' => SORT_ASC],
                    'desc' => ['date' => SORT_DESC],
                    'label' => 'Дата',
                ]
            ]
        ]);
        $this->load($params);

        if (!$this->validate()) {
            $query->joinWith('patient');
            return $dataProvider;
        }

        $query->joinWith(['patient' => function ($q) {
            $q->where('klinikpat.surname LIKE "' . $this->patientFullName . '%"');
        }]);

        if ($this->paid == self::SCHEME_PAID) {
            $query->where('summ=vnes');
        } elseif ($this->paid == self::SCHEME_NOT_PAID) {
            $query->where('summ<>vnes');
        }
        if ($this->sotr) {
            $query->where(['sotr' => $this->sotr]);
        }
        // grid filtering conditions
//        $query->andFilterWhere([
//            'id' => $this->id,
//            'pat' => $this->pat,
//            'sotr' => $this->sotr,
//            'date' => $this->date,
//            'per_lech' => $this->per_lech,
//            'summ' => $this->summ,
//            'summ_month' => $this->summ_month,
//            'vnes' => $this->vnes,
//            'full' => $this->full,
//            'last_pay_month' => $this->last_pay_month,
//        ]);

        return $dataProvider;
    }

    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['patientFullName'] = 'Пациент';
        //UserInterface::getVar($labels);
        return $labels;
    }
}
