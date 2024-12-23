<?php

namespace common\modules\statistics\models;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use yii\base\Model;
use common\modules\invoice\models\Invoice;
use common\modules\invoice\models\InvoiceItems;
use common\modules\pricelists\models\Pricelist;
use common\modules\reports\models\FinancialPeriods;
use common\modules\userInterface\models\UserInterface;
use yii\helpers\ArrayHelper;

/**
 * @property int $summary
 * @property InvoiceItems[] $allPositionsByPricelistType;
 */
class StatisticsCount extends Model
{
    const PERIODS_BEFORE = 6;

    public $startDate = "";
    public $endDate = "";
    public $pricelistType;
    public $pricelistId;
    public $invoiceItemIds;
    public $periods;


    public static function getForFinancialPeriod(FinancialPeriods $financialPeriod)
    {
        return self::getForPeriod($financialPeriod->nach, $financialPeriod->okonch);
    }

    public static function getForPeriod($startDate, $endDate)
    {
        $model = new self(
            [
                'startDate' => $startDate,
                'endDate' => $endDate,
            ]
        );

        return $model;
    }

    public static function getXlsxRevenue(array $periods, $financialPeriod = null)
    {
        $spreadsheet = new Spreadsheet();


        $name = 'Общий финасовый отчёт по выручке';
        if (mb_strlen($name) > 31) {
            $sheet_name = mb_substr($name, 0, 30);
        } else {
            $sheet_name = $name;
        }

        $rowNumber = 2;

        $mysheet = new Worksheet($spreadsheet, $sheet_name);
        $spreadsheet->addSheet($mysheet, 0);
        $sheet = $spreadsheet->getSheetByName($sheet_name);
        $sheet->setTitle($sheet_name);

        $diap = 'A' . $rowNumber . ':H' . $rowNumber;

        $styleArray = [
            'font' => [
                'bold' => true,
            ]
        ];
        $sheet->getStyle($diap)->applyFromArray($styleArray);

        $arrayData = ['Направление'];
        foreach ($periods as $period) {
            $arrayData[] = $period['title'];
        }

        $sheet->fromArray(
            $arrayData,  // The data to set
            NULL,        // Array values with this value will not be set
            'A' . $rowNumber         // Top left coordinate of the worksheet range where
        //    we want to set these values (default is A1)
        );
        $rowNumber++;

        $hygieneProductsStatistics = ['Сумма за период по средствам гигиены'];
        $material = ['Сумма за период по материалам'];
        $xRayStatistic = ['Сумма выручки рентген'];
        $clinicStatistic = ['Сумма выручки врачей по клинике'];


        foreach ($periods as $period) {
            $hygieneProductsStatistics [$period['id']] = HygieneProducts::getForPeriod($period['startDate'], $period['endDate'])->summary;
            $xRayStatistic [$period['id']] = XRayCount::getForPeriod($period['startDate'], $period['endDate'])->summary;
            $clinStat = ClinicStatistic::getForPeriod($period['startDate'], $period['endDate']);
            $clinicStatistic [$period['id']] = $clinStat->doctorsSummary - $xRayStatistic [$period['id']];
            $material [$period['id']] = $clinStat->materialSummary - $hygieneProductsStatistics [$period['id']];
        }


        $sheet->fromArray(
            $clinicStatistic,
            NULL,
            'A' . $rowNumber

        );
        $rowNumber++;

        $sheet->fromArray(
            $xRayStatistic,
            NULL,
            'A' . $rowNumber

        );
        $rowNumber++;

        $sheet->fromArray(
            $material,
            NULL,
            'A' . $rowNumber

        );
        $rowNumber++;

        $sheet->fromArray(
            $hygieneProductsStatistics,
            NULL,
            'A' . $rowNumber

        );
        $rowNumber++;

        $name = 'Финасовый отчёт врачи';
        if (mb_strlen($name) > 31) {
            $sheet_name = mb_substr($name, 0, 30);
        } else {
            $sheet_name = $name;
        }

        $rowNumber = 2;

        $mysheet = new Worksheet($spreadsheet, $sheet_name);
        $spreadsheet->addSheet($mysheet, 0);
        $sheet = $spreadsheet->getSheetByName($sheet_name);
        $sheet->setTitle($sheet_name);

        $diap = 'A' . $rowNumber . ':AC' . $rowNumber;

        $styleArray = [
            'font' => [
                'bold' => true,
            ]
        ];

        $sheet->getStyle($diap)->applyFromArray($styleArray);

        $arrayData = ['Врачи'];
        foreach ($periods as $period) {
            $arrayData[] = $period['title'] . ' выручка';
            $arrayData[] = $period['title'] . ' секунды';
            $arrayData[] = $period['title'] . ' часы';
            $arrayData[] = $period['title'] . ' в час';
        }

        $sheet->fromArray(
            $arrayData,  // The data to set
            NULL,        // Array values with this value will not be set
            'A' . $rowNumber         // Top left coordinate of the worksheet range where
        //    we want to set these values (default is A1)
        );
        $rowNumber++;

        $doctorStatistics = DoctorStatistics::getForFinancialPeriod($financialPeriod);
        foreach ($doctorStatistics->financial as $doctorStatistic) {
            foreach ($doctorStatistic as $employee_id => $employeeStat) {
                $arrayData = [$employeeStat['fullName']];
                foreach ($doctorStatistics->periods as $period) {


                    $arrayData [] = $employeeStat[$period['id']]['revenue'];
                    $arrayData [] = $employeeStat[$period['id']]['seconds'];
                    $arrayData [] = $employeeStat[$period['id']]['hour'];
                    $arrayData [] = $employeeStat[$period['id']]['revenue_per_hour'];

                }

                $sheet->fromArray(
                    $arrayData,  // The data to set
                    NULL,        // Array values with this value will not be set
                    'A' . $rowNumber         // Top left coordinate of the worksheet range where
                //    we want to set these values (default is A1)
                );
                $rowNumber++;
            }
        }


//        if ($pricelist->activeCategoryes) {
//
//
//            $sheet->setCellValue('A' . $rowNumber, $name);
//
//            $sheet->mergeCells('A' . $rowNumber . ':D' . $rowNumber);
//            $styleArray = [
//                'font' => [
//                    'bold' => true,
//                ]
//            ];
//
//            $sheet->getStyle($diap)->applyFromArray($styleArray);
//
//            $rowNumber++;
//            $sheet->getColumnDimension('A')->setWidth(7);
//            $sheet->getColumnDimension('B')->setWidth(60);
//            $sheet->getColumnDimension('C')->setWidth(14);
//            $sheet->getColumnDimension('D')->setWidth(7);
//            foreach ($pricelist->activeCategoryes as $categorye) {
//
//                $sheet->setCellValue('A' . $rowNumber, $categorye->title);
//                $sheet->mergeCells('A' . $rowNumber . ':D' . $rowNumber);
//                $styleArray = [
//                    'font' => [
//                        'bold' => true,
//                    ]
//                ];
//                $diap = $coefficient ? 'A' . ($rowNumber) . ':D' . $rowNumber : 'A' . ($rowNumber) . ':C' . $rowNumber;
//                $sheet->getStyle($diap)->applyFromArray($styleArray);
//                $rowNumber++;
//
//                $arrayData = ['Код', 'Наименование', 'Цена'];
//                if ($coefficient) {
//                    $arrayData[] = 'Коэф';
//                }
//                $styleArray = [
//
//                    'borders' => [
//                        'allBorders' => [
//                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
//                        ],
//                    ],
//                ];
//                $diap = $coefficient ? 'A' . ($rowNumber) . ':D' . $rowNumber : 'A' . ($rowNumber) . ':C' . $rowNumber;
//                $sheet->getStyle($diap)->applyFromArray($styleArray);
//                $sheet->fromArray(
//                    $arrayData,  // The data to set
//                    NULL,        // Array values with this value will not be set
//                    'A' . $rowNumber         // Top left coordinate of the worksheet range where
//                //    we want to set these values (default is A1)
//                );
//                $rowNumber++;
//                foreach ($categorye->activeItemsFromCategory as $item) {
//                    $arrayData = [$item->id, $item->title, $item->price . ' руб.',];
//                    if ($coefficient) {
//                        $arrayData[] = $item->Coefficient;
//                    }
//                    $sheet->fromArray(
//                        $arrayData,  // The data to set
//                        NULL,        // Array values with this value will not be set
//                        'A' . $rowNumber         // Top left coordinate of the worksheet range where
//                    //    we want to set these values (default is A1)
//                    );
//                    $sheet->getStyle('B' . $rowNumber)->getAlignment()->setWrapText(true);
//                    $styleArray = [
//                        'borders' => [
//                            'allBorders' => [
//                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
//                            ],
//                        ],
//                    ];
//                    $diap = $coefficient ? 'A' . ($rowNumber) . ':D' . $rowNumber : 'A' . ($rowNumber) . ':C' . $rowNumber;
//                    $sheet->getStyle($diap)->applyFromArray($styleArray);
//                    $rowNumber++;
//                }
//            }
//        }

        $sheetIndex = $spreadsheet->getIndex(
            $spreadsheet->getSheetByName('Worksheet')
        );
        $spreadsheet->removeSheetByIndex($sheetIndex);
        $writer = new Xlsx($spreadsheet);
        $fileName = 'pricelist.xlsx';
        $writer->save($fileName);
        return $fileName;
    }

    public function getAllPositionsByPricelistTypeQuery()
    {
        return InvoiceItems::find()
            ->leftJoin('invoice', 'invoice.id=invoice_items.invoice_id')
            ->leftJoin('prices', 'prices.id=invoice_items.prices_id')
            ->leftJoin('pricelist_items', 'pricelist_items.id=prices.pricelist_items_id')
            ->leftJoin('pricelist', '`pricelist`.`id`=`pricelist_items`.`pricelist_id`')
            ->where(['pricelist.type' => $this->pricelistType])
            ->andwhere('invoice.created_at>=\'' . $this->startDate . '\'')
            ->andWhere('invoice.created_at<=\'' . $this->endDate . '\'');
    }

    public function getAllPositionsByPricelistIdQuery()
    {
        return InvoiceItems::find()
            ->leftJoin('invoice', 'invoice.id=invoice_items.invoice_id')
            ->leftJoin('prices', 'prices.id=invoice_items.prices_id')
            ->leftJoin('pricelist_items', 'pricelist_items.id=prices.pricelist_items_id')
            ->leftJoin('pricelist', '`pricelist`.`id`=`pricelist_items`.`pricelist_id`')
            ->where(['pricelist.id' => $this->pricelistId])
            ->andWhere('invoice.paid=invoice.amount_payable')
            ->andwhere('invoice.created_at>=\'' . $this->startDate . '\'')
            ->andWhere('invoice.created_at<=\'' . $this->endDate . '\'');
    }

    public function getAllPositionsByPricelistType()
    {

        return $this->getAllPositionsByPricelistTypeQuery()->all();
    }

    public function getGroupPositionsByPricelistType()
    {
        //$this->getAllPositionsByPricelistTypeQuery()->groupBy('pricelist_items.id')->all();
        return $this->getAllPositionsByPricelistTypeQuery()
            ->select(['pricelist_items.id', 'SUM(invoice_items.quantity) as total', 'pricelist_items.title',])//
            ->groupBy('pricelist_items.id')
            ->asArray()
            ->all();
    }

    public function getAllPositionsByIds()
    {
        //$this->getAllPositionsByPricelistTypeQuery()->groupBy('pricelist_items.id')->all();
        return $this->getAllPositionsByPricelistTypeQuery()
            ->select(['pricelist_items.id', 'SUM(invoice_items.quantity) as total', 'pricelist_items.title',])//
            ->groupBy('pricelist_items.id')
            ->asArray()
            ->all();
    }

    public function getAllPositionsByPriceListId()
    {

        return $this->getAllPositionsByPricelistIdQuery()->all();
    }

    public function getSummary()
    {
        $summ = 0;
        foreach ($this->allPositionsByPricelistType as $position) {
            $summ += $position->summary;
        }
        return $summ;
    }

    public static function getPeriods($periodsBefore = self::PERIODS_BEFORE)
    {
        $periods = [];
        $financialPeriods = FinancialPeriods::find()->orderBy('id DESC')->limit($periodsBefore)->all();
        foreach ($financialPeriods as $period) {
            array_unshift($periods,
                [
                    'id' => $period->id,
                    'title' => UserInterface::getMonthNameFromDate($period->nach),
                    'startDate' => $period->nach,
                    'endDate' => $period->okonch,
                ]);
        }
        $periods['avg'] = [
            'id' => 'avg',
            'title' => 'Среднее',
            'startDate' => FinancialPeriods::getPeriodForCurrentDate()->nach,
            'endDate' => FinancialPeriods::getPeriodForCurrentDate()->okonch,
        ];
        return $periods;
    }
}