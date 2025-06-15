<?php

namespace common\modules\documents\controllers;

use common\components\Storage;
use common\modules\documents\models\Documents;
use common\modules\documents\models\DocumentTemplateWord;
use common\modules\patient\models\Patient;
use common\modules\userInterface\models\UserInterface;
use FPDF;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Writer\PDF\MPDF;
use setasign\Fpdi\Tfpdf\Fpdi;
use tFPDF;
use Yii;
use common\modules\documents\models\Notes;
use common\modules\documents\models\NotesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ManageController implements the CRUD actions for Notes model.
 */
class ManageController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        $this->layout = '@frontend/views/layouts/light';
        if (Yii::$app->request->get('patient_id') !== null) {
            Yii::$app->userInterface->params['patient_id'] = Yii::$app->request->get('patient_id');
        }
        return true; // or false to not run the action
    }

    /**
     * Lists all Notes models.
     * @return mixed
     */
    public function actionIndex($patient_id)
    {
        $searchModel = new NotesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $patient_id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Notes model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Print a single Notes model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionPrint($id)
    {
        $this->layout = '@frontend/views/layouts/print';
        return $this->render('print', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Notes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($type)
    {
        $model = new Notes();
        $model->author_id = Yii::$app->user->identity->employe_id;
        $model->patient_id = Yii::$app->userInterface->params['patient_id'];
        $model->type = $type;
        $model->title = Notes::getTypesList()[$type];
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view',
                'id' => $model->id,
                'patient_id' => $model->patient_id]);
        }

        return $this->render('create', [
            'model' => $model,
            'type' => $type,
        ]);
    }

    /**
     * Updates an existing Notes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view',
                'id' => $model->id, 'patient_id' => $model->patient_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Notes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index', 'patient_id' => Yii::$app->userInterface->params['patient_id']]);
    }

    /**
     * Finds the Notes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Notes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Notes::findOne($id)) !== null) {
            if (!isset(Yii::$app->userInterface->params['patient_id'])) {
                Yii::$app->userInterface->params['patient_id'] = $model->patient_id;
            }
            return $model;
        }

        throw new NotFoundHttpException('Запрашиваемая страница не найдена.');
    }

    public function actionPdf($notes_id)
    {
//        $pdf = new \FPDF();
//        $pdf->AddPage();
//        $pdf->SetFont('Arial', 'B', 16);
//        $pdf->Cell(40, 10, 'Hello World!');
//        $pdf->Output("/report.pdf", "I");
        $storage = new Storage();
        $path = $storage->getStoragePath(Storage::TYPE_DOCS);
        $templateProcessor = new TemplateProcessor($path . 'dogovor.docx');
        $templateProcessor->setValue('num_dogovor', '4444');
        $templateProcessor->setValue('name', 'Иванов Иван Иванович');
        $path = $storage->getStorageUri(Storage::TYPE_DOCS);
        $templateProcessor->saveAs('/var/www/orto/frontend/web' . $path . 'dogovor.docx');
        return $this->redirect([$path . 'dogovor.docx']);
    }

    public function actionDocx($notes_id)
    {
        $path = Yii::$app->components->getStoragePath(Storage::TYPE_DOCS);
        $templateProcessor = new TemplateProcessor($path . 'dogovor.docx');
    }

    public function actionPrintWord($patient_id, $template_id)
    {

        //https://stackoverflow.com/questions/47905960/how-to-convert-word-document-into-pdf-using-phpword
        ///var/www/html/orto/vendor/mpdf/mpdf# chmod 755 tmp разрешить запись ао временную директорию

        $var = get_defined_vars();

        DocumentTemplateWord::SaveTemplateStandardVars($var, $template_id);
        return $this->redirect(['index', 'patient_id' => Yii::$app->userInterface->params['patient_id']]);

    }

    public function actionPrintPdf($patient_id)
    {
//        $pdf = new Fpdi();
//
//        $pdf->AddPage();
//        $pdf->SetFont('times', 'B', 16);
//        $pdf->Cell(40, 10,  'Тест');
        // initiate FPDI
        define('FPDF_FONTPATH', Yii::getAlias('@frontend') . '/web/fonts/');
        $pdf = new Fpdi();
// add a page
        $pdf->AddPage();
// set the source file
        $pdf->setSourceFile(Yii::getAlias('@frontend') . "/web/templates/ids.pdf");
// import page 1
        $tplIdx = $pdf->importPage(1);
// use the imported page and place it at point 10,10 with a width of 100 mm
        $pdf->useImportedPage($tplIdx);

// now write some text above the imported page
//        $pdf->SetFont('Montserrat');

        $pdf->AddFont('Montserrat-Regular', '', 'montserrat/Montserrat-Regular.ttf', true);
        $pdf->SetFont('Montserrat-Regular', '', 10);

        $pdf->SetXY(13, 15);
        $pdf->Write(0, Patient::findOne($patient_id)->fullName);

        //$pdf->Output();
        $pdf->Output("/report.pdf", "I");

        //Из ворд шаблона
        $storage = new Storage();

        $path = $storage->getStoragePath(Storage::TYPE_DOCS);


        $templateProcessor = new TemplateProcessor($path . 'dog_temp.docx');
        $templateProcessor = DocumentTemplateWord::findOne($template_id)->templateProcessor;

//        $templateProcessor->setValue('num_dogovor', '4444');


        $templateProcessor->setValue('PatientName', Patient::findOne($patient_id)->fullName);

        $path = $storage->getStorageUri(Storage::TYPE_DOCS);

        $wordFileName = Yii::getAlias('@frontend') . '/web' . $path . 'temp.docx';
        $templateProcessor->saveAs($wordFileName);

        Settings::setPdfRendererName(Settings::PDF_RENDERER_MPDF);
        Settings::setPdfRendererPath('.');

        $document = IOFactory::load($wordFileName);
        $pdfFileName = Yii::getAlias('@frontend') . '/web' . $path . 'document.pdf';
        $document->save($pdfFileName, 'PDF');

//        return $this->redirect(['index','patient_id'=>$patient_id]);
        return $this->redirect([$path . 'temp.docx']);
    }

    public function actionSign($hash)
    {
        $document = new Documents(
            [
                'hash' => $hash,
                'employee_id' => UserInterface::getEmployeeId(),
                'signed' => true
            ]);
        $document->save(false);

        return $this->redirect(['index', 'patient_id' => Yii::$app->userInterface->params['patient_id']]);
    }

    public function actionUnsign($document_id)
    {
        $document = Documents::findOne($document_id);
        $document->delete();

        return $this->redirect(['index', 'patient_id' => Yii::$app->userInterface->params['patient_id']]);
    }
}