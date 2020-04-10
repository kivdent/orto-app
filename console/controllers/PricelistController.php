<?php


namespace console\controllers;


use common\models\InvoiceForSchemeOrthodontics;
use common\modules\catalogs\models\Manipulations;
use common\modules\catalogs\models\Pricelists;
use common\modules\invoice\models\Invoice;
use common\modules\invoice\models\InvoiceItems;
use common\modules\patient\models\MedicalRecords;
use common\modules\pricelists\models\Pricelist;
use common\modules\pricelists\models\PricelistItems;
use common\modules\pricelists\models\Prices;
use Throwable;
use yii\console\Controller;
use yii\helpers\Html;

class PricelistController extends Controller


{
    const manip = 'manip';
    const manip_08_09_2019 = 'manip_08_09_2019';
    const manip_14_01_2019 = 'manip_14_01_2019';
    const manip_11_02_2018 = 'manip_11_02_2018';


    private $periods = [
        'manip_11_02_2018' => ['start' => '2007-01-01', 'end' => '2018-02-11', 'prices' => []],//$periods[table][prices][old_manip_id]=>prices_id,
        'manip_14_01_2019' => ['start' => '2018-02-12', 'end' => '2019-01-14', 'prices' => []],
        'manip_08_09_2019' => ['start' => '2019-01-15', 'end' => '2019-09-08', 'prices' => []],
        'manip' => ['start' => '2019-09-09', 'end' => '3021-01-01', 'prices' => []],
    ];
    private $manipulationTables = ['manip_11_02_2018', 'manip_14_01_2019', 'manip_08_09_2019', 'manip'];
    private $priceLists = [];//$priceLists[old_id]=new_id
    private $priceListItems = [];//$priceListItems[old_id]=new_id,
    private $pricesIds = [];//$pricesIds[old_id][table]=new_id
//invoiceТаблица чеков
//invoiceItems таблица манипуляций
//compl Название столбца чека в таблице манипуляций
    private $tables = array(
        'dnev' => array(
            'invoice' => "dnev",
            'invoiceItems' => "manip_pr",
            'compl' => "dnev",
            'paymentType' => 1,
            'addition' => ''
        ),
        'zaknar' => array(
            'invoice' => "zaknar",
            'invoiceItems' => "manip_zn",
            'compl' => "ZN",
            'paymentType' => 2,
            'addition' => ''
        ),
        'schet_orto' => array
        (
            'invoice' => "schet_orto",
            'invoiceItems' => "manip_sh_orto",
            'compl' => "SO",
            'paymentType' => 3,
            'addition' => ' `sh_id`=0) AND'
        )
    );

    public function actionMigrate()
    {
        $this->clearTables();
        $transaction = Pricelist::getDb()->beginTransaction();
        try {

            $this->copyPrices();
            $this->createPriceListItems();
            $this->copyPriceListItems();
            $this->copyInvoices();
            $transaction->commit();
            return true;
        } catch (Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    public function clearTables()
    {
        echo "Очиска таблиц прейскурантов....";
//        Pricelist::deleteAll();
//        PricelistItems::deleteAll();
//        Prices::deleteAll();
//        Invoice::deleteAll();
//        InvoiceItems::deleteAll();
//        InvoiceForSchemeOrthodontics::deleteAll();
        $sql = "SET FOREIGN_KEY_CHECKS = 0; 
        TRUNCATE `invoice`;
TRUNCATE `invoice_for_scheme_orthodontics`;
TRUNCATE `invoice_items`;
TRUNCATE `pricelist`;
TRUNCATE `pricelist_items`;
TRUNCATE `prices`;
SET FOREIGN_KEY_CHECKS = 1;";
        \Yii::$app->db->createCommand($sql)->execute();
        echo "Выполнено \n";
    }

    /**
     * @var Pricelists $oldPrice
     */
    public function copyPrices()
    {
        echo "Копирование таблиц прейскурантов....";
        $oldPrices = Pricelists::find()->all();

        foreach ($oldPrices as $oldPrice) {

            $priceList = new Pricelist();
            $priceList->title = $oldPrice->preysk;
            $priceList->type = Pricelist::TYPE_MANIPULATIONS;
            $priceList->active = Pricelist::STATUS_ACTIVE;
            $priceList->save(false);

            $this->priceLists[$oldPrice->id] = $priceList->id;


        }
        echo "Выполнено \n";


    }

    public function copyPriceListItems()
    {
//        `manip`.`manip`,+
//`manip`.`preysk`,+
//`manip`.`zapis`,
//`manip`.`price`+
//`manip`.`cat`,+
//`manip`.`UpId`,+
//`manip`.`range`,
//`manip`.`koef`+

//        `pricelist_items`.`title`,+
//`pricelist_items`.`pricelist_id`,+
//`pricelist_items`.`category`,+
//`pricelist_items`.`superior_category_id`,+
//`pricelist_items`.`active`+

//        `prices`.`pricelist_items_id`,+
//`prices`.`price`,+
//`prices`.`coefficient`,+
//`prices`.`created_at`,
//`prices`.`updated_at`,
//`prices`.`active`+
        echo "Копирование элементов прейскурантов....";
        foreach ($this->periods as $table => $period) {


            $sql = "SELECT * FROM " . $table;

            $manipulations = \Yii::$app->db->createCommand($sql)->queryAll();
            foreach ($manipulations as $manipulation) {

                $prices = new Prices();

                $prices->price = $manipulation['price'];
                $prices->coefficient = $manipulation['koef'];
                $prices->active = $table == self::manip;
                if (!array_key_exists($manipulation['id'], $this->priceListItems)) {
                    $priceListItem = new PricelistItems();

                    $priceListItem->title = $manipulation['manip'];
                    if (!array_key_exists($manipulation['preysk'], $this->priceLists)) {
                        $priceList = new Pricelist();

                        $priceList->title = "Удалённый прейскурант со идентификатором " . $manipulation['preysk'];
                        $priceList->type = Pricelist::TYPE_MANIPULATIONS;
                        $priceList->active = 0;
                        $priceList->save(false);

                        $this->priceLists[$manipulation['preysk']] = $priceList->id;
                    }
                    $priceListItem->pricelist_id = $this->priceLists[$manipulation['preysk']];
                    $priceListItem->category = $manipulation['cat'];
                    $priceListItem->superior_category_id = $this->priceListItems[$manipulation['UpId']];
                    $priceListItem->active = PricelistItems::STATUS_INACTIVE;
                    $priceListItem->save(false);
                    $this->priceListItems[$manipulation['id']] = $priceListItem->id;

                }
                $prices->pricelist_items_id = $this->priceListItems[$manipulation['id']];
                $prices->save(false);


                $this->pricesIds[$manipulation['id']][$table] = $prices->id;
                //$this->priceListItems[$manipulation['id']][$table] = $prices->id;

            }
        }
        echo "Выполнено \n";
    }

    public function createPriceListItems()
    {
        echo "Копирование элементов прейскурантов....";
        $manipulations = Manipulations::find()->where(['cat' => 1])->asArray()->all();
        foreach ($manipulations as $manipulation) {

            $priceListItem = new PricelistItems();

            $priceListItem->title = $manipulation['manip'];
            if (!array_key_exists($manipulation['preysk'], $this->priceLists)) {
                $priceList = new Pricelist();

                $priceList->title = "Удалённый прейскурант со идентификатором " . $manipulation['preysk'];
                $priceList->type = Pricelist::TYPE_MANIPULATIONS;
                $priceList->active = 0;
                $priceList->save(false);

                $this->priceLists[$manipulation['preysk']] = $priceList->id;
            }
            $priceListItem->pricelist_id = $this->priceLists[$manipulation['preysk']];
            $priceListItem->category = $manipulation['cat'];
            $priceListItem->superior_category_id = 0;
            $priceListItem->active = PricelistItems::STATUS_ACTIVE;
            $priceListItem->save(false);
            $this->priceListItems[$manipulation['id']] = $priceListItem->id;
        }

        $manipulations = Manipulations::find()->where(['cat' => 0])->asArray()->all();
        foreach ($manipulations as $manipulation) {

            $priceListItem = new PricelistItems();

            $priceListItem->title = $manipulation['manip'];
            if (!array_key_exists($manipulation['preysk'], $this->priceLists)) {
                $priceList = new Pricelist();

                $priceList->title = "Удалённый прейскурант со идентификатором " . $manipulation['preysk'];
                $priceList->type = Pricelist::TYPE_MANIPULATIONS;
                $priceList->active = 0;
                $priceList->save(false);

                $this->priceLists[$manipulation['preysk']] = $priceList->id;
            }
            $priceListItem->pricelist_id = $this->priceLists[$manipulation['preysk']];
            $priceListItem->category = $manipulation['cat'];
            $priceListItem->superior_category_id = $this->priceListItems[$manipulation['UpId']];
            $priceListItem->active = PricelistItems::STATUS_ACTIVE;
            $priceListItem->save(false);
            $this->priceListItems[$manipulation['id']] = $priceListItem->id;
        }
        echo "Выполнено \n";
    }

    private
    function copyInvoices()
    {


        echo "Копирование счетов....";
        foreach ($this->periods as $tableName => $period) {
            echo "Период " . $period['start'] . "-" . $period['end'];
            foreach ($this->tables as $table) {
                echo "Таблица " . $table['invoice'];
                $sql = "SELECT * 
                        FROM `" . $table['invoice'] . "` 
                        WHERE (
                        (`date`>='" . $period['start'] . "') AND 
                        (`date`<='" . $period['end'] . "')
                        )";
                $oldInvoices = \Yii::$app->db->createCommand($sql)->queryAll();
                $this->createNewInvoices($oldInvoices, $table, $tableName);
            }
        }
        echo "Выполнено \n";
    }

    private
    function createNewInvoices(array $oldInvoices, array $table, $tableName)
    {
        // `dnev`.`vrach`,+
//`dnev`.`pat`,+
//`dnev`.`date`+
//`dnev`.`osm`,
//`dnev`.`ds`,
//`dnev`.`zh`,+
//`dnev`.`an`,+
//`dnev`.`obk`,
//`dnev`.`lech`,
//`dnev`.`resl`,
//`dnev`.`summ`,+
//`dnev`.`summ_k_opl`,+
//`dnev`.`summ_vnes`,+
//`dnev`.`skidka`,
//`dnev`.`nzub`,
//`dnev`.`Nid`
//`invoice`.`doctor_id`,+
//`invoice`.`patient_id`,+
//`invoice`.`created_at`,+
//`invoice`.`updated_at`,+
//`invoice`.`amount`,+
//`invoice`.`amount_payable`,+
//`invoice`.`paid`,+
//`invoice`.`discount_id`,
//`invoice`.`appointment_id`,
//`invoice`.`type`

        foreach ($oldInvoices as $oldInvoice) {
            $invoice = new Invoice();
            $invoice->doctor_id = $oldInvoice['vrach'];
            $invoice->patient_id = $oldInvoice['pat'];
            $invoice->created_at = $oldInvoice['date'] . " 00:00:00";
            $invoice->updated_at = $invoice->created_at;
            $invoice->amount = $oldInvoice['summ'];
            $invoice->amount_payable = $oldInvoice['summ_k_opl'];
            $invoice->paid = $oldInvoice['summ_vnes'];
            $invoice->discount_id = $oldInvoice['skidka'];
            $invoice->type = Invoice::TYPE_MANIPULATIONS;

            $invoice->save(false);
            $invoice->created_at = $oldInvoice['date'] . " 00:00:00";
            $invoice->updated_at = $invoice->created_at;
            switch ($table['invoice']) {
                case 'dnev':
                    $invoice->appointment_id = $oldInvoice['Nid'];
                    $sql = "SELECT * FROM `ds_pr` where `pr`=" . $oldInvoice['id'];
                    $ds = \Yii::$app->db->createCommand($sql)->queryAll();

                    if ($ds) {
                        $this->createMedicalRecords($invoice, $oldInvoice, $ds);
                    }
                    if ($invoice->doctor_id == 0) {
                        $invoice->type = Invoice::TYPE_MATERIALS;
                    }
                    break;

                case 'schet_orto':
                    if ($oldInvoice['sh_id']) {
                        $sql = "SELECT `sh_id` FROM `schet_orto_schema` WHERE `id`=" . $oldInvoice['sh_id'];
                        $sh_id = \Yii::$app->db->createCommand($sql)->queryAll();
                        $invoice_to_scheme = new InvoiceForSchemeOrthodontics();
                        $invoice_to_scheme->scheme_orthodontics_id = $sh_id[0]['sh_id'];
                        $invoice_to_scheme->invoice_id = $invoice->id;
                        $invoice->type = Invoice::TYPE_ORTHODONTICS;
                        $invoice_to_scheme->save(false);
                    }
                    break;
            }
            $this->createInvoiceItems($oldInvoice['id'], $invoice->id, $table, $tableName);
            $invoice->save(false);
            $sql = "UPDATE `oplata`
                    SET `dnev` =" . $invoice->id . "                  
                    WHERE (
                            (`dnev` =" . $oldInvoice['id'] . ") AND
                            (`type` = " . $table['paymentType'] . ")
                        )";
            \Yii::$app->db->createCommand($sql)->execute();
        }
    }

    private
    function createMedicalRecords(Invoice $invoice, $oldInvoice, array $ds)
    {

//    `medical_records`.`region_id`,+
//    `medical_records`.`diagnosis_id`,+
//    `medical_records`.`complaints`,+
//    `medical_records`.`anamnesis`,+
//    `medical_records`.`objectively`,+
//    `medical_records`.`recommendations`,+
//    `medical_records`.`prescriptions`,+
//    `medical_records`.`invoice_id`,+
//    `medical_records`.`therapy`,+
//    `medical_records`.`created_at`,+
//    `medical_records`.`updated_at`,+
//    `medical_records`.`date`,+
//    `medical_records`.`employe_id`,+
//    `medical_records`.`patient_id`+
//FROM `orto-temp`.`medical_records`;
        $region = [
            '1' => 2,
            '18' => 9,
            '17' => 10,
            '16' => 11,
            '15' => 12,
            '14' => 13,
            '13' => 14,
            '12' => 15,
            '11' => 16,
            '21' => 17,
            '22' => 18,
            '23' => 19,
            '24' => 20,
            '25' => 21,
            '26' => 22,
            '27' => 23,
            '28' => 24,
            '38' => 25,
            '37' => 26,
            '36' => 27,
            '35' => 28,
            '34' => 29,
            '33' => 30,
            '32' => 31,
            '31' => 32,
            '41' => 33,
            '42' => 34,
            '43' => 35,
            '44' => 36,
            '45' => 37,
            '46' => 38,
            '47' => 39,
            '48' => 40,
        ];
        foreach ($ds as $diagnosis) {
            $medicalRecord = new MedicalRecords();

            $medicalRecord->region_id = $region[$diagnosis['NZub']];
            $medicalRecord->diagnosis_id = $diagnosis['ds'];
            $medicalRecord->complaints = Html::encode($oldInvoice['zh']);
            $medicalRecord->anamnesis = Html::encode($oldInvoice['an']);
            $medicalRecord->objectively = Html::encode($oldInvoice['obk']);
            $medicalRecord->therapy = Html::encode($oldInvoice['lech']);
            $medicalRecord->invoice_id = $invoice->id;
            $medicalRecord->created_at = $invoice->created_at;
            $medicalRecord->updated_at = $invoice->created_at;
            $medicalRecord->date = $oldInvoice['date'];
            $medicalRecord->recommendations = '';
            $medicalRecord->prescriptions = '';
            $medicalRecord->employe_id = $invoice->doctor_id;
            $medicalRecord->patient_id = $invoice->patient_id;

            $medicalRecord->save(false);

        }
    }

    private
    function createInvoiceItems($dnev_id, $invoice_id, array $table, $tableName)
    {
//        SELECT `manip_pr`.`id`,
//    `manip_pr`.`NZuba`,
//    `manip_pr`.`manip`,
//    `manip_pr`.`kolvo`,
//    `manip_pr`.`dnev`,
//    `manip_pr`.`type`
//FROM `orto-temp`.`manip_pr`;
//        `invoice_items`.`prices_id`,+
//`invoice_items`.`quantity`,
//`invoice_items`.`invoice_id`+

        $sql = "SELECT *
                FROM `" . $table['invoiceItems'] . "`
                WHERE `" . $table['compl'] . "`=" . $dnev_id;

        $dnev_items = \Yii::$app->db->createCommand($sql)->queryAll();

        foreach ($dnev_items as $dnev_item) {
            if (!isset($this->pricesIds[$dnev_item['manip']][$tableName])) {
                $flag = 1;
                foreach ($this->periods as $tablePeriods) {
                    if (isset($this->pricesIds[$dnev_item['manip']][$tablePeriods])) {
                        $flag = 0;
                        $this->pricesIds[$dnev_item['manip']][$tableName] = $this->pricesIds[$dnev_item['manip']][$tablePeriods];
                    }
                }
                if ($flag) {
                    $prices = new Prices();

                    $prices->price = 0;
                    $prices->coefficient = 0;
                    $prices->active = 0;
                    if (!array_key_exists($dnev_item['manip'], $this->priceListItems)) {
                        $priceListItem = new PricelistItems();

                        $priceListItem->title = "Удалённая манипуляция со идентификатором " . $dnev_item['manip'];;

                        $priceListItem->pricelist_id = 1;
                        $priceListItem->category = 0;
                        $priceListItem->superior_category_id = 0;
                        $priceListItem->active = PricelistItems::STATUS_INACTIVE;
                        $priceListItem->save(false);
                        $this->priceListItems[$dnev_item['manip']] = $priceListItem->id;

                    }
                    $prices->pricelist_items_id = $this->priceListItems[$dnev_item['manip']];
                    $prices->save(false);

                    $this->pricesIds[$dnev_item['manip']][$tableName] = $prices->id;


                }
            }
            $invoiceItem = new InvoiceItems();

            $invoiceItem->invoice_id = $invoice_id;

            $invoiceItem->prices_id = $this->pricesIds[$dnev_item['manip']][$tableName];
            $invoiceItem->quantity = $dnev_item['kolvo'];

            $invoiceItem->save(false);
        }
    }

}