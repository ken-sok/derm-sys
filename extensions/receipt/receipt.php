<?php

require_once "../../controllers/sales.controller.php";
require_once "../../models/sales.model.php";

require_once "../../controllers/diagnosis.controller.php";
require_once "../../models/diagnosis.model.php";

require_once "../../controllers/customers.controller.php";
require_once "../../models/customers.model.php";

require_once "../../controllers/products.controller.php";
require_once "../../models/products.model.php";


//call the autoload
require_once 'vendor/autoload.php';
//load phpspreadsheet class using namespaces
use PhpOffice\PhpSpreadsheet\Spreadsheet;
//call iofactory instead of xlsx writer
use PhpOffice\PhpSpreadsheet\IOFactory;



class printBill{

public $code;


public function getDiagnosisSaved(){

//WE BRING THE INFORMATION OF THE SALE


$itemSale = "code";
$valueSale = $this->code;

$answerSale = ControllerSales::ctrShowSales($itemSale, $valueSale);

$saledate = substr($answerSale["saledate"],0,-8);
$products = json_decode($answerSale["products"], true);

//Customer

$itemCustomer = "id";
$valueCustomer = $answerSale["idCustomer"];

$answerCustomer = ControllerCustomers::ctrShowCustomers($itemCustomer, $valueCustomer);

//diagnosis

$item = 'id';
$value = $answerSale["diagnosis"];

$diagnosis = ControllerDiagnosis::ctrShowDiagnosis($item, $value);




//load from template
$reader = IOFactory::createReader('Xlsx');
$spreadsheet = $reader->load("template_receipt.xlsx");

//set default font	
$spreadsheet->getDefaultStyle()
	->getFont()
	->setName('Khmer OS')
        ->setSize(10);
        
        
//add customer info to page
foreach($spreadsheet->getActiveSheet()->getRowDimensions() as $rd) {  $rd->setRowHeight(-1); }
foreach($spreadsheet->getActiveSheet()->getColumnDimensions() as $rd) {  $rd->setWidth(-1); }
/*
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(16);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(13.71);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(13);
*/
$spreadsheet->getActiveSheet()
        ->setCellValue('B8' , $answerCustomer['name'], '&B')
        ->setCellValue('E8' , 'អាយុ '.$answerCustomer['age'].'ឆ្នាំ')
        ->setCellValue('D9' , 'ភេទ '.$answerCustomer['sex']);

//add diagnosis
$spreadsheet->getActiveSheet()
		->setCellValue('B10' , $diagnosis['name']);



//add product
$i = 1; 
foreach ($products as $key => $item) {

	$cellNum = 10+$i; 
    $spreadsheet->getActiveSheet()
            ->setCellValue('A'.$cellNum  , $i)
            ->setCellValue('B'.$cellNum, $item['description'])
            ->setCellValue('C'.$cellNum, $item['quantity'].'pcs')
            ->setCellValue('D'.$cellNum , $item['usage']);
        $i = $i + 1; 
}

$saledateDB = date_create($answerSale["saledate"]);
$saledate = date_format($saledateDB, 'd-m-Y');

//date

$spreadsheet->getActiveSheet()
->setCellValue('C20', $saledate);

//set the header first, so the result will be treated as an xlsx file.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

//make it an attachment so we can define filename
header('Content-Disposition: attachment;filename="'.$valueSale.'.xlsx"');

//create IOFactory object
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
//save into php output
$writer->save('php://output');

}

}


$bill = new printBill();
$bill -> code = $_GET["code"];
$bill -> getDiagnosisSaved();
