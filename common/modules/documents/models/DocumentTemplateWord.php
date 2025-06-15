<?php

namespace common\modules\documents\models;

use common\components\Storage;
use common\modules\employee\models\Employee;
use common\modules\userInterface\models\UserInterface;
use Exception;
use PhpOffice\PhpWord\TemplateProcessor;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\web\UploadedFile;



/**
 *
 * @property-read string $docLink
 * @property-read string $docFile
 * @property-read TemplateProcessor $templateProcessor
 * @property-read array $templateVariables
 * @property-read string $templateVariablesString
 * @property-read Employee $employee
 * @property-read string $filePath
 */





class DocumentTemplateWord extends \common\models\DocumentTemplateWord
{

    public $uploadedFile;

    const STORAGE_TYPE = Storage::TYPE_DOCS_TEMPLATES;

    public static function getPatFiles($patient_id)
    {
        $links = [];
        try {
            foreach (FileHelper::findFiles(Yii::getAlias('@frontend') . '/web' . self::getDocPath($patient_id)) as $filePath) {
                $fileName = explode('/', $filePath);
                $fileName = end($fileName);
                $hash=md5(self::getDocPath($patient_id) . $fileName);
                $document=Documents::findOne(['hash' => $hash]);
                if ( $document!== null){
                    $button=Html::a('Снять подпись',[
                        'unsign',
                        'document_id'=>$document->id,'patient_id'=>$patient_id],
                        ['class'=>'btn btn-success btn-xs']
                    );
                }else{
                    $button=Html::a(
                        'Подпсать',
                        ['sign','hash'=>$hash,'patient_id'=>$patient_id],
                        ['class'=>'btn btn-danger btn-xs']
                    );
                }

                $links [] = Html::a(' '.$fileName, self::getDocPath($patient_id) . $fileName, ['target' => '_blank']).$button;
            }
        } catch (Exception $e) {
            $links[]='Документов нет';
        }


        return $links;
    }

    public static function getTemplateList()
    {
        $list = [];

        foreach (DocumentTemplateWord::find()->all() as $templateWord) {
            $list[$templateWord->id] = $templateWord->title;
        }
        return $list;
    }

    public static function SaveTemplateStandardVars($args, $template_id)
    {
        $link = '';
        $variables = [];
        $documentTemplateWord = DocumentTemplateWord::findOne($template_id);
        $tp = $documentTemplateWord->templateProcessor;
        foreach ($documentTemplateWord->templateVariables as $variable) {
            $variables[$variable] = TemplateVariables::getStandardVariableValue($variable, $args);
//            UserInterface::getVar($variable,false);
//            UserInterface::getVar(TemplateVariables::getStandardVariableValue($variable,$args),false);
            $tp->setValue($variable, TemplateVariables::getStandardVariableValue($variable, $args));
        }
        //UserInterface::getVar($documentTemplateWord->templateProcessor);
//        $tp = $documentTemplateWord->templateProcessor;
//        $tp->setValue('PatientName', '4444');


        $wordFileName = self::getDocFileName($documentTemplateWord, $args['patient_id']);

        $tp->saveAs($wordFileName);


        return self::getPatDocLink($documentTemplateWord, $args['patient_id']);
    }

    private static function getDocFileName(DocumentTemplateWord $documentTemplateWord, $patient_id)
    {
        $path = Yii::getAlias('@frontend') . '/web/' . self::getDocPath($patient_id) . $documentTemplateWord->title . '.docx';

        $path = FileHelper::normalizePath($path);

        if (FileHelper::createDirectory(dirname($path))) {
            return $path;
        }
    }

    private static function getDocPath($patient_id)
    {
        return Yii::$app->storage->getStorageUri(Storage::TYPE_DOCS) . $patient_id . '/';
    }

    private static function getPatDocLink(DocumentTemplateWord $documentTemplateWord, $patient_id)
    {
        return self::getDocPath($patient_id) . $documentTemplateWord->title . '.docx';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    public function __construct($config = [])
    {
        parent::__construct($config);

//        $this->setTemplateVariables();
//        if (!$this->isNewRecord) {
//            $this->setTemplateVariables();
//        }

        return true;
    }

    public function beforeSave($insert)
    {
        $this->employee_id = UserInterface::getEmployeeId();
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if (!$this->isNewRecord) {
            Yii::$app->storage->deleteFile($this->file_name, $this->getFilePath(), self::STORAGE_TYPE);
        }
        return $this->saveUploadedFile();

    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'created_at' => 'Создан',
            'updated_at' => 'Удалён',
            'file_name' => 'Файл',
            'description' => 'Описание',
            'variables' => 'Перменные пользователя',
            'employee_id' => 'Сотрудник',
            'uploadedFile' => 'Шаблон',
            'templateVariablesString' => 'Перменные документа',
        ];
    }

    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [['title'], 'required'];
        $rules[] = [['uploadedFile'], 'file',
            'skipOnEmpty' => false,
            'extensions' => ['doc', 'docx', 'DOC',],
            'checkExtensionByMimeType' => true,
            'maxSize' => 1024 * 1024 * 10];
//        $rules[] = [['uploadedFile'], 'safe'];

        return $rules;
    }

    public function beforeValidate()
    {

        $this->uploadedFile = UploadedFile::getInstance($this, 'uploadedFile');

        return true;
    }

    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        return Yii::$app->storage->deleteFile($this->file_name, $this->getFilePath(), self::STORAGE_TYPE);
    }

    private function saveUploadedFile()
    {

        $this->file_name = Yii::$app->storage->saveUploadedFile($this->uploadedFile, $this->getFilePath(), self::STORAGE_TYPE);

        if (!$this->file_name) {
            return false;
        }
        return true;
    }

    private function getFilePath()
    {
        return '';
    }

    public function getDocLink()
    {
        return (Yii::$app->storage->getFileLink($this->file_name, $this->getFilePath(), self::STORAGE_TYPE) !== null) ?
            Yii::$app->storage->getFileLink($this->file_name, $this->getFilePath(), self::STORAGE_TYPE) : '';
    }

    public function getDocFile()
    {
        return Yii::$app->storage->getStoragePath(self::STORAGE_TYPE) . $this->file_name;
    }

    public function getTemplateVariablesString()
    {
        return implode(', ', $this->templateVariables);
    }

    public function getTemplateVariables()
    {
        $templateProcessor = $this->templateProcessor;

        return $this->templateProcessor->getVariables();
    }

    public function getTemplateProcessor()
    {
        return new TemplateProcessor($this->docFile);
    }

    public function getEmployee(){
        return $this->hasOne(Employee::class,['id'=>'employee_id']);
    }

}