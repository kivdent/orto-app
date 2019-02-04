<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Hello World !');
$Sheet->setTitle('Прайс-лист');
// Шапка и футер (при печати)
$Sheet->getHeaderFooter()
       ->setOddHeader('&CПрейскурант');
$Sheet->getHeaderFooter()
       ->setOddFooter('&L'.date(d.m.Y).'&RДиректор ООО /"Орто-Премьер/" Черненко С');
$writer = new Xlsx($spreadsheet);
$writer->save('hello world.xlsx');