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
        $products = json_decode($answerSale["products"], true);

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
        <td width="100%"><img src = "images/whole-top.png"></td>

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
    ​​​​    <td width = "15%" style="font-size: 15;">ឈ្មោះ</td>
        <td width = "25%" style="font-size: 15;">$answerCustomer[name]</td>
        
        
        <td width = "15%" style="font-size: 15;">ភេទ</td>
        <td width = "15%" style="font-size: 15;">$answerCustomer[sex]</td>
        
        <td width = "15%" style="font-size: 15;">អាយុ</td>
        <td width = "15%" style="font-size: 15;">$answerCustomer[age]​ ឆ្នាំ</td>
        
	</tr>
    


</table>

<table cellpadding="5px" autosize="1" border="0" width="100%" style="overflow: wrap">
<tr>
<td width="30%" style="font-size: 15;">រោគវិនិច្ឆ័យ</td>
<td width="70%" style="font-size: 15;">$diagnosis[name]</td>
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
        <td width="30%" style="font-size: 15;" align="center"><p>បរិយាយឳសថ<br>Description</p></td>
        <td width="20%" style="font-size: 15;" align="center"><p>ចំនួន<br>Units</p></td>
        <td width="40%" style="font-size: 15;" align="center"><p> ការប្រើប្រាស់<br>Recommendations</p></td>

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
    
    $productUsage = $item['usage'];
    
    $block4 = <<<EOF
    
        <table cellpadding="5px" autosize="1" border="1" width="100%" style="overflow: wrap">
    
            <tr>
                <td width="10%" style="font-size: 15;" align="center">$i</td>
                <td width="30%" style="font-size: 15;" align="center">$nameProduct</td>
                <td width="20%" style="font-size: 15;" align="center">$valueUnit $valueScale</td>
                <td width="40%" style="font-size: 15;" align="center">$productUsage</td>
            </tr>
    
        </table>
    
    
    EOF;
    $i++;

    
    $mpdf->writeHTML($block4);
    
}
    
// ---------------------------------------------------------     

// ---------------------------------------------------------

$block5 = <<<EOF


    <table>
                
    <tr>
        
        <td><img src="images/_blank.png" width = "1"></td>

    </tr>

    </table>

 
    <table cellpadding="5px" autosize="1" border="0" width="100%" style="overflow: wrap">


		<tr>
	
        <td width="10%" style="font-size: 15;" align="right"><p>កាលបរិច្ឆេទ $saledate</p></td>


		</tr>

	</table>

EOF;

$mpdf->writeHTML($block5);
    
// ---------------------------------------------------------    
$mpdf->Output();


    }
}

$consult = new printConsult();
$consult -> code = $_GET["code"];
$consult ->getConsultPrinted();
