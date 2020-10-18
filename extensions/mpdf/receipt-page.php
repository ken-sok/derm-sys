<?php

require_once __DIR__ . '/autoload.php';
require_once "../../controllers/sales.controller.php";
require_once "../../models/sales.model.php";

require_once "../../controllers/diagnosis.controller.php";
require_once "../../models/diagnosis.model.php";

require_once "../../controllers/customers.controller.php";
require_once "../../models/customers.model.php";

require_once "../../controllers/products.controller.php";
require_once "../../models/products.model.php";

class printConsult{

    public $code; 
    public function getConsultPrinted(){


        $itemSale = "code";
        $valueSale = $this->code;

        $answerSale = ControllerSales::ctrShowSales($itemSale, $valueSale);

        $saledateDB = date_create($answerSale["saledate"]);
        $saledate = date_format($saledateDB, 'd-m-Y');
        $products = json_decode($answerSale["receipt"], true);

        $totalPriceUSD = number_format((float)$answerSale["totalPrice"], 2, '.', '');
        $khmerTotal = $answerSale["totalPrice"]*$answerSale["exchangeRate"]; 
        $totalPriceKH = number_format($khmerTotal);

        //Customer

        $itemCustomer = "id";
        $valueCustomer = $answerSale["idCustomer"];

        $answerCustomer = ControllerCustomers::ctrShowCustomers($itemCustomer, $valueCustomer);

        //diagnosis

        $item = 'id';
        $value = $answerSale["diagnosis"];

        $diagnosis = ControllerDiagnosis::ctrShowDiagnosis($item, $value);

        $mpdf = new \Mpdf\Mpdf([
            'tempDir' => __DIR__ . '/custom/temp/dir/path', 
            'default_font_size'=> 20, 
            'default_font' => 'khmeros', 
            'format' => 'A5', 
            'margin_left' => 5,
            'margin_right' => 5,
            'margin_top' => 5,
            'margin_bottom' => 5,
            'margin_header' => 5,
            'margin_footer' => 5,
        ]);
        
//---------------------------------------------------------MUST NOT USE TAB
$block1 = <<<EOF

<table>
    <tr>
        <td width="100%"><img src = "images/receipt-top.png"></td>

    </tr>

</table>

EOF;
$mpdf->writeHTML($block1);

//---------------------------------------------------------
$block2 = <<<EOF


<table>
            
<tr>
    
    <td><img src="images/_blank.png" width = "1"></td>

</tr>

</table>

    <table cellpadding="5px" autosize="1" border="0" width="100%" style="overflow: wrap">

    <tr>

    <td width="10%" style="font-size: 20;" align="center"><p><b>RECEIPT</b></p></td>
    
    </tr>

</table>

<table cellpadding="5px" autosize="1" border="0" width="100%" style="overflow: wrap">

    <tr>

    <td width="66%" style="font-size: 15;" align="left"><p>កាលបរិច្ឆេទ Date $saledate</p></td>
    <td width="0%" style="font-size: 15;" align="left"></td>
    <td width="33%" style="font-size: 15;" align="right"><p color="red">No. $valueSale</p></td>

    </tr>

</table>

<table cellpadding="5px" autosize="1" border="0" width="100%" style="overflow: wrap">


	<tr>
    ​​​​    <td width = "100%" style="font-size: 15;">ឈ្មោះអតិថិជន Customer's Name   $answerCustomer[name]</td>
    
        
	</tr>
    
</table>


EOF;

$mpdf->writeHTML($block2);
//---------------------------------------------------------


// ---------------------------------------------------------

$block3 = <<<EOF

    <table>
            
        <tr>
            
            <td><img src="images/_blank.png" width = "1"></td>

        </tr>

    </table>


    <table cellpadding="5px" autosize="1" border="1" width="100%" style="overflow: wrap">


		<tr>
	
        <td width="10%" style="font-size: 15;" align="center"><p>ល.រ.<br>No.</p></td>
        <td width="25%" style="font-size: 13;" align="center"><p>បរិយាយមុខទំនិញ<br>Description</p></td>
        <td width="15%" style="font-size: 15;" align="center"><p>ចំនួន<br>Units</p></td>
        <td width="15%" style="font-size: 15;" align="center"><p>តម្លៃរាយ<br>Unit Price</p></td>
        <td width="15%" style="font-size: 15;" align="center"><p>តម្លៃសរុប<br>Amount</p></td>
        <td width="20%" style="font-size: 15;" align="center"><p>ផ្សេងៗ<br>Others</p></td>

		</tr>

	</table>

EOF;

$mpdf->writeHTML($block3);

// ---------------------------------------------------------

// ---------------------------------------------------------
$i = 1; 

foreach ($products as $key => $item) {

    $nameProduct = $item['description'];

    $valueUnit = number_format($item['quantity']);
    $valueScale = $item['scale']; 
    
    

    $unitPrice = number_format((float)$item['price'], 2, '.', '');
    $totalPriceItem = number_format((float)$item['totalPrice'], 2, '.', '');


    
$block4 = <<<EOF

    <table cellpadding="5px" autosize="1" border="1" width="100%" style="overflow: wrap">

        <tr>
            <td width="10%" style="font-size: 15;" align="center">$i</td>
            <td width="25%" style="font-size: 15;" align="center">$nameProduct</td>
            <td width="15%" style="font-size: 15;" align="center">$valueUnit $valueScale</td>
            <td width="15%" style="font-size: 15;" align="center">$unitPrice</td>
            <td width="15%" style="font-size: 15;" align="center">$totalPriceItem</td>
            <td width="20%" style="font-size: 15;" align="center"></td>
        </tr>

    </table>


EOF;
    $i++;

    
    $mpdf->writeHTML($block4);
    
}
    
// ---------------------------------------------------------     

// ---------------------------------------------------------
$block5 = <<<EOF


<table cellpadding="5px" autosize="1" border="1" width="100%" style="overflow: wrap">

    <tr>

    <td width="65%" style="font-size: 15;" align="right"><u>សរុប Total</u></td>
    <td width="35%" style="font-size: 15;" align="left"> $totalPriceKH ៛ <br> $totalPriceUSD $ </td>

    </tr>

</table>

EOF;
$mpdf->writeHTML($block5);
// ---------------------------------------------------------


// ---------------------------------------------------------

$block6 = <<<EOF


    <table>
                
    <tr>
        
        <td><img src="images/_blank.png" width = "1"></td>

    </tr>

    </table>

 
    <table cellpadding="5px" autosize="1" border="0" width="100%" style="overflow: wrap">


		<tr>
	
        <td width="50%" style="font-size: 15;" align="left"><p>Customer</td>
        <td width="50%" style="font-size: 15;" align="right"><p>Staff</td>


		</tr>

	</table>

EOF;

$mpdf->writeHTML($block6);
    
// ---------------------------------------------------------    
$mpdf->Output();


    }
}

$consult = new printConsult();
$consult -> code = $_GET["code"];
$consult ->getConsultPrinted();
