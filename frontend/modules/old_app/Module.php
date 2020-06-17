<?php

namespace frontend\modules\old_app;

use Yii;
use common\interfaces\WorkModuleInterface;
use common\abstractClasses\WorkModule;

/**
 * old_app 
 * Модуль для интеграции старых функций
 */
class Module extends WorkModule {
    
    /**
     * {@inheritdoc}
     */
    public $dbName="";
    public $controllerNamespace = 'frontend\modules\old_app\controllers';
    public $moduleName="Функции старой версии";
    public $userprava = [
        'admin' => '1',
        'therapist' => '2',
        'orthopedist' => '3',
        'orthodontist' => '4',
        'recorder' => '5',
        'accountant' => '6',
        'senior_nurse' => '7',
        'director' => '13',
        'radiologist' => '14',
        'surgeon' => '17',
        'technician' => '4',
    ];
   /**
     * {@inheritdoc}
     */
    public function init() {
        parent::init();
        Yii::configure($this, require __DIR__ . '/menu.php');
        $this->dbName= $this->getDsnAttribute('dbname', Yii::$app->getDb()->dsn);
        
    }

    private function getDsnAttribute($name, $dsn)
    {
        if (preg_match('/' . $name . '=([^;]*)/', $dsn, $match)) {
            return $match[1];
        } else {
            return null;
        }
    }
}
