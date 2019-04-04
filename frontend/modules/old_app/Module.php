<?php

namespace frontend\modules\old_app;

use Yii;
use common\interfaces\ModuleInterface;

/**
 * old_app 
 * Модуль для интеграции старых функций
 */
class Module extends \yii\base\Module implements ModuleInterface {

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\old_app\controllers';
    public $userprava = [
        'admin' => '1',
        'therapist' => '2',
        'orthopedist' => '3',
        'orthodontist' => '4',
        'recorder' => '5',
        'accountant' => '6',
        'senior nurse' => '7',
        'director' => '13',
        'radiologist' => '14',
        'surgeon' => '17',
    ];
  

    /**
     * {@inheritdoc}
     */
    public function init() {
        parent::init();
        Yii::configure($this, require __DIR__ . '/menu.php');
        
    }
    /**
     * 
     * @param type $roleName Название роли пользователя
     * @return array ['label'=>'route']
     */

    public function getMenuItemsByRole($roleName) {
        return $this->params['menuItems'][$roleName];
    }

}
