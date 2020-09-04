<?php

require_once "../controllers/products.controller.php";
require_once "../models/products.model.php";

require_once "../controllers/customers.controller.php";
require_once "../models/customers.model.php";


class productsTableConsultation{

	/*=============================================
 	 SHOW PRODUCTS TABLE
  	=============================================*/ 
	public function showProductsTableConsultation(){

		$item = null;
		$value = null;
		$order = "id";

		$products = ControllerProducts::ctrShowProducts($item, $value, $order);

		if(count($products) == 0){

			$jsonData = '{"data":[]}';

			echo $jsonData;

			return;
		}

		$jsonData = '{
			"data":[';

				for($i=0; $i < count($products); $i++){


					/*=============================================
					We bring the image
					=============================================*/
					
					$image = "<img src='".$products[$i]["image"]."' width='40px'>";


		  			/*=============================================
		 	 		ACTION BUTTONS
		  			=============================================*/ 

		  			$buttons =  "<div class='btn-group'><button class='btn btn-primary addProductSale recoverButton' idProduct='".$products[$i]["id"]."'>Add</button></div>";

						$jsonData .='[
							"'.($i+1).'",
							"'.$image.'",
							"'.$products[$i]["code"].'",
							"'.$products[$i]["description"].'",
							"'.$buttons.'"
						],';
					
				}

				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 

			}';

		echo $jsonData;
	}
}


/*=============================================
ACTIVATE PRODUCTS TABLE
=============================================*/ 
$activateProductsConsultation = new productsTableConsultation();
$activateProductsConsultation -> showProductsTableConsultation();
