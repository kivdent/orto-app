<?php


namespace common\modules\pricelists\models;


use common\modules\userInterface\models\UserInterface;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Yii;
use yii\helpers\ArrayHelper;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use yii\web\UploadedFile;

class Pricelist extends \common\models\Pricelist
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const TYPE_MANIPULATIONS = 'manipulations';
    const TYPE_MATERIALS = 'materials';
    const TYPE_GIFT_CARDS = 'gift_cards';

    public static function saveToYandexDisk()
    {
        $filename=self::getXlsxPriceList(false);
        $resourceName='/pricelist/pricelist.xlsx';
        Yii::$app->storage->saveToYandexDisk($filename, $resourceName);
    }

    static function getXlsxPriceList($coefficient)
    {

        $spreadsheet = new Spreadsheet();

        foreach (Pricelist::find()->where(['active' => Pricelist::STATUS_ACTIVE])->all() as $pricelist) {
            $preysk_name = $pricelist->title;
            if (mb_strlen($preysk_name) > 31) {
                $sheet_name = mb_substr($preysk_name, 0, 30);
            } else {
                $sheet_name = $preysk_name;
            }

            $a = 1;

            if ($pricelist->activeCategoryes) {

                $mysheet = new Worksheet($spreadsheet, $sheet_name);
                $spreadsheet->addSheet($mysheet, 0);
                $sheet = $spreadsheet->getSheetByName($sheet_name);
                // $invalidCharacters = array('*', ':', '/', '\\', '?', '[', ']');
                //$invalidCharacters = $sheet->getInvalidCharacters();
                //  $preysk_name=str_replace($invalidCharacters, '', $preysk_name);
                $sheet->setTitle($sheet_name);
                $sheet->getHeaderFooter()
                    ->setOddHeader('&C' . $preysk_name);
                $sheet->getHeaderFooter()
                    ->setOddFooter('&L' . date('d.m.Y') . '&RДиректор ООО "Орто-Премьер" Черненко С.В.');
                $sheet->setCellValue('A' . $a, $preysk_name);

                $sheet->mergeCells('A' . $a . ':D' . $a);
                $styleArray = [
                    'font' => [
                        'bold' => true,
                    ]
                ];
                $diap = $coefficient ? 'A' . ($a) . ':D' . $a : 'A' . ($a) . ':C' . $a;
                $sheet->getStyle($diap)->applyFromArray($styleArray);

                $a++;
                $sheet->getColumnDimension('A')->setWidth(7);
                $sheet->getColumnDimension('B')->setWidth(60);
                $sheet->getColumnDimension('C')->setWidth(14);
                $sheet->getColumnDimension('D')->setWidth(7);
                foreach ($pricelist->activeCategoryes as $categorye) {

                    $sheet->setCellValue('A' . $a, $categorye->title);
                    $sheet->mergeCells('A' . $a . ':D' . $a);
                    $styleArray = [
                        'font' => [
                            'bold' => true,
                        ]
                    ];
                    $diap = $coefficient ? 'A' . ($a) . ':D' . $a : 'A' . ($a) . ':C' . $a;
                    $sheet->getStyle($diap)->applyFromArray($styleArray);
                    $a++;

                    $arrayData = ['Код', 'Наименование', 'Цена'];
                    if ($coefficient) {
                        $arrayData[] = 'Коэф';
                    }
                    $styleArray = [

                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ],
                    ];
                    $diap = $coefficient ? 'A' . ($a) . ':D' . $a : 'A' . ($a) . ':C' . $a;
                    $sheet->getStyle($diap)->applyFromArray($styleArray);
                    $sheet->fromArray(
                        $arrayData,  // The data to set
                        NULL,        // Array values with this value will not be set
                        'A' . $a         // Top left coordinate of the worksheet range where
                    //    we want to set these values (default is A1)
                    );
                    $a++;
                    foreach ($categorye->activeItemsFromCategory as $item) {
                        $arrayData = [$item->id, $item->title, $item->price . ' руб.',];
                        if ($coefficient) {
                            $arrayData[] = $item->Coefficient;
                        }
                        $sheet->fromArray(
                            $arrayData,  // The data to set
                            NULL,        // Array values with this value will not be set
                            'A' . $a         // Top left coordinate of the worksheet range where
                        //    we want to set these values (default is A1)
                        );
                        $sheet->getStyle('B' . $a)->getAlignment()->setWrapText(true);
                        $styleArray = [
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                ],
                            ],
                        ];
                        $diap = $coefficient ? 'A' . ($a) . ':D' . $a : 'A' . ($a) . ':C' . $a;
                        $sheet->getStyle($diap)->applyFromArray($styleArray);
                        $a++;
                    }
                }
            }
        }
        $sheetIndex = $spreadsheet->getIndex(
            $spreadsheet->getSheetByName('Worksheet')
        );
        $spreadsheet->removeSheetByIndex($sheetIndex);
        $writer = new Xlsx($spreadsheet);
        $fileName = 'pricelist.xlsx';
        $writer->save($fileName);
        return $fileName;
    }

    public
    static function getBatchEditingXls(array $newPricesArray)
    {
        /* @var $pricelist Pricelist */

        $spreadsheet = new Spreadsheet();

        foreach (Pricelist::find()->where(['active' => Pricelist::STATUS_ACTIVE])->all() as $pricelist) {
            $preysk_name = $pricelist->title;
            if (mb_strlen($preysk_name) > 31) {
                $sheet_name = mb_substr($preysk_name, 0, 30);
            } else {
                $sheet_name = $preysk_name;
            }

            $a = 1;

            if ($pricelist->activeCategoryes) {

                $mysheet = new Worksheet($spreadsheet, $sheet_name);
                $spreadsheet->addSheet($mysheet, 0);
                $sheet = $spreadsheet->getSheetByName($sheet_name);
                // $invalidCharacters = array('*', ':', '/', '\\', '?', '[', ']');
                //$invalidCharacters = $sheet->getInvalidCharacters();
                //  $preysk_name=str_replace($invalidCharacters, '', $preysk_name);
                $sheet->setTitle($sheet_name);
                $sheet->getHeaderFooter()
                    ->setOddHeader('&C' . $preysk_name);
                $sheet->getHeaderFooter()
                    ->setOddFooter('&L' . date('d.m.Y') . '&RДиректор ООО "Орто-Премьер" Черненко С.В.');

                $sheet->setCellValue('A1', $pricelist->id);//A1-id прейскуранта

                $sheet->setCellValue('A' . $a, $preysk_name); //Название прайса на листе
                $sheet->mergeCells('A' . $a . ':F' . $a);
                $styleArray = [
                    'font' => [
                        'bold' => true,
                    ]
                ];
                $diap = 'A' . ($a) . ':F' . $a;
                $sheet->getStyle($diap)->applyFromArray($styleArray);
                $a++;
                $sheet->getColumnDimension('A')->setWidth(7);
                $sheet->getColumnDimension('B')->setWidth(60);
                $sheet->getColumnDimension('C')->setWidth(14);
                $sheet->getColumnDimension('D')->setWidth(7);
                $sheet->getColumnDimension('E')->setWidth(14);
                $sheet->getColumnDimension('F')->setWidth(7);
                foreach ($pricelist->activeCategoryes as $categorye) {

                    $sheet->setCellValue('A' . $a, $categorye->title);
                    $sheet->mergeCells('A' . ($a) . ':F' . $a);
                    $styleArray = [
                        'font' => [
                            'bold' => true,
                        ]
                    ];

                    $sheet->getStyle($diap)->applyFromArray($styleArray);
                    $a++;

                    $arrayData = ['Код', 'Наименование', 'Цена', 'Коэф', 'Нов Цена', 'Нов Коэф',];
                    $styleArray = [

                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ],
                    ];

                    $sheet->getStyle($diap)->applyFromArray($styleArray);
                    $sheet->fromArray(
                        $arrayData,  // The data to set
                        NULL,        // Array values with this value will not be set
                        'A' . $a         // Top left coordinate of the worksheet range where
                    //    we want to set these values (default is A1)
                    );
                    $a++;
                    foreach ($categorye->activeItemsFromCategory as $item) {
                        $arrayData = [
                            $item->id,
                            $item->title,
                            $item->price . ' руб.',
                            $item->Coefficient,
                            isset($newPricesArray[$item->id]['price']) ? $newPricesArray[$item->id]['price'] : $item->price,
                            isset($newPricesArray[$item->id]['coefficient']) ? $newPricesArray[$item->id]['coefficient'] : $item->Coefficient,
                        ];
                        $sheet->fromArray(
                            $arrayData,  // The data to set
                            NULL,        // Array values with this value will not be set
                            'A' . $a         // Top left coordinate of the worksheet range where
                        //    we want to set these values (default is A1)
                        );
                        $sheet->getStyle('B' . $a)->getAlignment()->setWrapText(true);
                        $styleArray = [
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                ],
                            ],
                        ];
                        $sheet->getStyle($diap)->applyFromArray($styleArray);
                        $a++;
                    }
                }
            }
        }
        $sheetIndex = $spreadsheet->getIndex(
            $spreadsheet->getSheetByName('Worksheet')
        );
        $spreadsheet->removeSheetByIndex($sheetIndex);
        $writer = new Xlsx($spreadsheet);
        $fileName = 'pricelist_batch_editing.xlsx';
        $writer->save($fileName);
        return $fileName;
    }

    public
    static function getBatchEditingDataFromXls($file)
    {
        $newPriceArray = [];
        $path = "images/" . $file[0]->name;
        $file[0]->saveAs($path);
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
        $sheets = $spreadsheet->getAllSheets();
        foreach ($sheets as $sheet) {

            $cells = $sheet->getCellCollection();
            for ($row = 1; $row <= $cells->getHighestRow(); $row++) {
                if ($cells->get('A' . $row) and is_numeric($cells->get('A' . $row)->getValue())) {

                    $newPriceArray[] = [
                        'id' => $cells->get('A' . $row)->getValue(),
                        'price' => $cells->get('E' . $row)->getValue(),
                        'coefficient' => $cells->get('F' . $row)->getValue(),
                    ];
                }
            }
        }
        unlink($path);
        return $newPriceArray;
    }


    public
    function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'active' => 'Активен',
            'type' => 'Тип',
        ];
    }

    public
    function getStatus()
    {
        return $this->active;
    }

    public
    static function getStatusList()
    {
        return [
            self::STATUS_ACTIVE => 'Активный',
            self::STATUS_INACTIVE => 'Неактивный',
        ];
    }

    public
    static function getTypeList()
    {
        return [
            self::TYPE_MANIPULATIONS => 'Манипуляции',
            self::TYPE_MATERIALS => 'Материалы',
            self::TYPE_GIFT_CARDS => 'Подарочные сертификаты',
        ];
    }

    public
    function getStatusName()
    {
        return $this->statusList[$this->active];
    }

    public
    static function getList()
    {
        $list = self::find()->all();
        return $list;
    }

    public
    static function getActiveList($type)
    {
//        $list = self::find()->where(['active' => Pricelist::STATUS_ACTIVE]);

        if (is_array($type)) {
            $where = ['and', 'active =' . Pricelist::STATUS_ACTIVE,];
            $types = ['or'];
            foreach ($type as $item) {
                if (array_key_exists($item, self::getTypeList())) {
                    $types[] = 'type=\'' . $item . '\'';
//                    $list = $list->andWhere(['type' => $item]);
                }
            }
            $where[] = $types;
        } elseif (array_key_exists($type, self::getTypeList())) {
            $where = ['active' => Pricelist::STATUS_ACTIVE, 'type' => $type];
//            $list = $list->andWhere(['type' => $type]);
        } else {
            $where = ['active' => Pricelist::STATUS_ACTIVE];
        }

        $list = self::find()->where($where)->all();
        return $list;
    }

    public
    function getCategoryes()
    {
        return PricelistItems::find()->where(['pricelist_id' => $this->id, 'category' => 1])->all();
    }

    public
    function getActiveCategoryes()
    {
        return PricelistItems::find()->where(['pricelist_id' => $this->id, 'category' => 1, 'active' => 1])->all();
    }

    public
    static function getListArray()
    {
        return ArrayHelper::map(self::getList(), 'id', 'title');
    }
}