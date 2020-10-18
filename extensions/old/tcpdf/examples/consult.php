<?php
require_once "../../../controllers/sales.controller.php";
require_once "../../../models/sales.model.php";

require_once "../../../controllers/diagnosis.controller.php";
require_once "../../../models/diagnosis.model.php";

require_once "../../../controllers/customers.controller.php";
require_once "../../../models/customers.model.php";

require_once "../../../controllers/products.controller.php";
require_once "../../../models/products.model.php";




class printConsult{

    public $code; 
    public function getConsultPrinted(){


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



//DO NOT USE TAB
// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');


// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'utf-8', false);

$pdf ->startPageGroup();

$pdf->AddPage('P', 'A5');
//$fontname = TCPDF_FONTS::addTTFfont("C:/Users/khean/Downloads/kmSBBICsf/kmSBBICsf.ttf", "TrueTypeUnicode", "", 32);
//echo $fontname;
// use KHMER OS font
$pdf->SetFont("kmsbbicsf", '', 12);
//---------------------------------------------------------

$block1 = <<<EOF

    <table>
        <tr>
            <td style="width:100%"><img src = "images/whole-top.png"></td>

        </tr>

    </table>

EOF;
$pdf->writeHTML($block1, false,false,false,false, '');
//---------------------------------------------------------
$block2 = <<<EOF

<table border="0">

	<tr>
        <td width="12%" ><img src="images/namekh.png" width = "30" ></td>
        <td width="38%" style="background-color:white;" >$answerCustomer[name]</td>

        <td width="10%" ><img src="images/sexkh.png" width = "20"></td>
        <td width="15%" style="background-color:white;">$answerCustomer[sex]</td>
        
        <td width="15%"><img src="images/agekh.png" width = "30"></td>
        <td width="15%" style="background-color:white;">$answerCustomer[age]</td>
	</tr>
    
    
    <tr>
        <td width="30%" ><img src="images/diagkh.png" width = "50" ></td>
        <td width="70%" style="background-color:white;" >$diagnosis[name]</td>

    </tr>
</table>

EOF;

$pdf->writeHTML($block2, false,false,false,false, '');
//---------------------------------------------------------


// ---------------------------------------------------------

$block3 = <<<EOF

    <table>
            
        <tr>
            
            <td><img src="images/back.jpg" width = "1"></td>

        </tr>

    </table>


    <table style="font-size:15px; padding:5px 10px;" border = "1">


		<tr>
		
		<td width="10%" ><img src="images/numberkh.png" width = "20"></td>
		<td width="40%" align="center"><img src="images/descriptionkh.png" width = "50"></td>
        <td width="10%" ><img src="images/unitskh.png" width = "20"></td>
		<td width="40%" align="center"><img src="images/usagekh.png" width = "80"></td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($block3, false, false, false, false, '');

// ---------------------------------------------------------

// ---------------------------------------------------------
$i = 1; 

foreach ($products as $key => $item) {

    $nameProduct = $item['description'];

    $valueUnit = number_format($item['quantity']);
    
    $productUsage = $item['usage'];
    
    $block4 = <<<EOF
    
        <table style="font-size:10px; padding:5px 10px;" border = "1">
    
            <tr>
                <td style="border: 1px solid #666; color:#333; background-color:white; width:10%;">
                    $i
                </td>
                <td style="border: 1px solid #666; color:#333; background-color:white; width:40%; text-align:center">
                    $nameProduct
                </td>
                <td style="border: 1px solid #666; color:#333; background-color:white; width:10%;">
                    $valueUnit
                </td>
                <td style="border: 1px solid #666; color:#333; background-color:white; width:40%; text-align:center">
                    មួយ ថ្ងៃ មួយ ដង
                </td>
            </tr>
    
        </table>
    
    
    EOF;


    
    $pdf->writeHTML($block4, false, false, false, false, '');
    
}
    
// ---------------------------------------------------------    

$pdf->Output('Consultation'.$_GET["code"].'.pdf'); 
}
}
$consult = new printConsult();
$consult -> code = $_GET["code"];
$consult ->getConsultPrinted();


?>