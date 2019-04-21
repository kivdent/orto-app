<?php

namespace common\modules\userInterface\models;

use Yii;

/**
 * This is the model class for table "addresses".
 *
 * @property int $id
 * @property int $postcode
 * @property string $city
 * @property string $street
 * @property string $house
 * @property string $apartment
 */
class Addresses extends \yii\db\ActiveRecord implements \common\interfaces\AddressInterface {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'addresses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [[ 'street', 'house'], 'required'],
            [['postcode'], 'integer'],
            [['city'], 'string', 'max' => 25],
            [['street'], 'string', 'max' => 100],
            [['house'], 'string', 'max' => 20],
            [['apartment'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'postcode' => 'Индекс',
            'city' => 'Город',
            'street' => 'Улица',
            'house' => 'Дом',
            'apartment' => 'Квартира',
        ];
    }

    /**
     * @return integer индекс
     */
    public function getPostcode(){}

    /**
     * @return string название города
     */
    public function getCity(){}

    /**
     * @return  string название улицы
     */
    public function getStreet(){}

    /**
     * @return  string номер дома
     */
    public function getHouse(){}

    /**
     * @return  string квартиры
     */
    public function getApartment(){}

    public static function getById($id){
        return self::findOne($id);
    }

    /**
     * 
     * получение списка 
     */
    public static function getAll(){}

    /**
     * получение идентификатора
     */
    public function getId(){}
  
     public function getAddressString(){
         return $this->postcode." ".$this->city." ".$this->street." ".$this->house." ".$this->apartment;
     }
}
