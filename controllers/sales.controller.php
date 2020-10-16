<?php



class ControllerSales
{

	/*=============================================
	SHOW SALES
	=============================================*/

	static public function ctrShowSales($item, $value)
	{

		$table = "sales";

		$answer = ModelSales::mdlShowSales($table, $item, $value);

		return $answer;
	}

	/*=============================================
	CREATE SALE
	=============================================*/

	static public function ctrCreateSale()
	{

		if (isset($_POST["newSale"])) {

			/*=============================================
				VALIDATE IMAGE
			=============================================*/

			if (isset($_FILES["newConsultPhoto"])) {
				$routeArray = array();

				for ($i = 0; $i < count($_FILES["newConsultPhoto"]); $i++) {


					$route = "views/img/consultations/default/anonymous.png";

					list($width, $height) = getimagesize($_FILES["newConsultPhoto"]["tmp_name"][$i]);

					//$newWidth = 500;
					//$newHeight = 500;

				/*=============================================
				we create the folder to save the picture
				=============================================*/

					$folder = "views/img/consultations/" . $_POST["newSale"];

					mkdir($folder, 0755);

				/*=============================================
				WE APPLY DEFAULT PHP FUNCTIONS ACCORDING TO THE IMAGE FORMAT
				=============================================*/

					if ($_FILES["newConsultPhoto"]["type"][$i] == "image/jpeg") {

					/*=============================================
					WE SAVE THE IMAGE IN THE FOLDER
					=============================================*/

						$random = mt_rand(100, 999);

						$route = "views/img/consultations/" . $_POST["newSale"] . "/" . $random . ".jpg";

						$origin = imagecreatefromjpeg($_FILES["newConsultPhoto"]["tmp_name"][$i]);

						$destiny = imagecreatetruecolor($width, $height);

						imagecopyresized($destiny, $origin, 0, 0, 0, 0, $width, $height, $width, $height);

						imagejpeg($destiny, $route);
					}

					if ($_FILES["newConsultPhoto"]["type"][$i] == "image/png") {

					/*=============================================
					WE SAVE THE IMAGE IN THE FOLDER
					=============================================*/

						$random = mt_rand(100, 999);

						$route = "views/img/consultations/" . $_POST["newSale"] . "/" . $random . ".png";

						$origin = imagecreatefrompng($_FILES["newConsultPhoto"]["tmp_name"][$i]);

						$destiny = imagecreatetruecolor($width, $height);

						imagecopyresized($destiny, $origin, 0, 0, 0, 0, $width, $height, $width, $height);

						imagepng($destiny, $route);
					}

					array_push($routeArray, $route);
				}
			}

			
			/*=============================================
			SAVE THE SALE
			=============================================*/

			$table = "sales";

			

			if ($_POST["process"] == "consult") {
				//pictures array
				$routeArrayJSON = json_encode($routeArray);
				$priceKH = $_POST["saleTotal"]*4100; 

				$data = array(
					"idCustomer" => $_POST["selectCustomer"],
					"code" => $_POST["newSale"],
					"products" => $_POST["productsList"],
					"receipt" => $_POST["productsList"],
					"totalPrice" => $_POST["saleTotal"],
					"totalPriceKH" => $priceKH,
					"comment" => $_POST["comment"],
					"diagnosis" => $_POST["selectDiagnosis"],
					"images" => $routeArrayJSON
				);
			} else {

				$data = array(
					"idCustomer" => $_POST["selectCustomer"],
					"code" => $_POST["newSale"],
					"products" => $_POST["productsList"],
					"receipt" => $_POST["productsList"],
					"totalPrice" => $_POST["saleTotal"],
					"totalPriceKH" => $_POST["saleTotalKH"],
					"comment" => $_POST["comment"],
					"diagnosis" => 1,
					"images" => ''
				);

			}

			$answer = ModelSales::mdlAddSale($table, $data);

			if ($answer == "ok") {


				if ($_POST["process"] == "consult") {
					echo '<script>

					localStorage.removeItem("range");

					swal({
						type: "success",
						title: "The consultation has been succesfully added",
						showConfirmButton: true,
						confirmButtonText: "Save"
						}).then((result) => {
									if (result.value) {

									window.location = "consultation";

									}
								})

					</script>';
					
				} else {

					echo '<script>

					localStorage.removeItem("range");

					swal({
						type: "success",
						title: "The receipt has been succesfully added",
						showConfirmButton: true,
						confirmButtonText: "Save"
						}).then((result) => {
									if (result.value) {

									window.location = "sales";

									}
								})

					</script>';
				}
			}
		}
	}



	/*=============================================
	EDIT SALE
	=============================================*/

	static public function ctrEditSale()
	{

		if (isset($_POST["editSale"])) {

			/*=============================================
			FORMAT PRODUCTS AND CUSTOMERS TABLES
			=============================================*/
			$table = "sales";

			$item = "code";
			$value = $_POST["editSale"];

			$getSale = ModelSales::mdlShowSales($table, $item, $value);

			$productsList = $_POST["productsList"];
			
			//all old photos
			$routeArrayJSON = $_POST["currentConsultPhoto"];

			/*=============================================
				VALIDATE IMAGE
			=============================================*/
			
			if (isset($_FILES["editConsultPhoto"])) {
				$routeOldArray = explode(',', $routeArrayJSON);

				$routeArray = array();

				for ($i = 0; $i < count($_FILES["editConsultPhoto"]); $i++) {

					$route = "views/img/consultations/default/anonymous.png";

					list($width, $height) = getimagesize($_FILES["editConsultPhoto"]["tmp_name"][$i]);



					/*=============================================
					we create the folder to save the picture
					=============================================*/

					$folder = "views/img/consultations/" . $_POST["newSale"];

					mkdir($folder, 0755);

					/*=============================================
					WE APPLY DEFAULT PHP FUNCTIONS ACCORDING TO THE IMAGE FORMAT
					=============================================*/

					if ($_FILES["editConsultPhoto"]["type"][$i] == "image/jpeg") {

						/*=============================================
						WE SAVE THE IMAGE IN THE FOLDER
						=============================================*/

						$random = mt_rand(100, 999);

						$route = "views/img/consultations/" . $_POST["newSale"] . "/" . $random . ".jpg";

						$origin = imagecreatefromjpeg($_FILES["editConsultPhoto"]["tmp_name"][$i]);

						$destiny = imagecreatetruecolor($width, $height);

						imagecopyresized($destiny, $origin, 0, 0, 0, 0, $width, $height, $width, $height);

						imagejpeg($destiny, $route);
					}

					if ($_FILES["editConsultPhoto"]["type"][$i] == "image/png") {

						/*=============================================
						WE SAVE THE IMAGE IN THE FOLDER
						=============================================*/

						$random = mt_rand(100, 999);

						$route = "views/img/consultations/" . $_POST["newSale"] . "/" . $random . ".png";

						$origin = imagecreatefrompng($_FILES["editConsultPhoto"]["tmp_name"][$i]);

						$destiny = imagecreatetruecolor($width, $height);

						imagecopyresized($destiny, $origin, 0, 0, 0, 0, $width, $height, $width, $height);

						imagepng($destiny, $route);
					}

					if (($route == "views/img/consultations/default/anonymous.png") && isset($routeOldArray[$i])){
						$route = json_decode($routeOldArray[$i]);
					}

					array_push($routeArray, $route);
				}
				//put inside because to avoid re-encoding json of exisiting images array
				$routeArrayJSON = json_encode($routeArray);
			}

		
			$table = "sales";

			if ($_POST["process"] == "consult") {


				$data = array(
					"idCustomer" => $_POST["selectCustomer"],
					"code" => $_POST["editSale"],
					"products" => $productsList,
					"receipt" => $getSale["receipt"],
					"totalPrice" => $_POST["saleTotal"],
					"comment" => $_POST["comment"],
					"diagnosis" => $_POST["editDiagnosis"], 
					"images" =>$routeArrayJSON
				);
				
			} else {

				$data = array(
					"idCustomer" => $_POST["selectCustomer"],
					"code" => $_POST["editSale"],
					"products" => $getSale["products"],
					"receipt" => $productsList,
					"totalPrice" => $_POST["saleTotal"],
					"comment" => $_POST["comment"],
					"diagnosis" => $_POST["editDiagnosis"], 
					"images" =>$routeArrayJSON
				);
			}

			$answer = ModelSales::mdleditSale($table, $data);

			if ($answer == "ok") {



				if ($_POST["process"] == "consult") {
					echo '<script>

					localStorage.removeItem("range");
	
					swal({
						  type: "success",
						  title: "The consultation has been edited correctly",
						  showConfirmButton: true,
						  confirmButtonText: "Save"
						  }).then((result) => {
									if (result.value) {
	
									window.location = "consultation";
	
									}
								})
	
					</script>';
				} else {

					echo '<script>

					localStorage.removeItem("range");

					swal({
						type: "success",
						title: "The receipt has been edited correctly",
						showConfirmButton: true,
						confirmButtonText: "Save"
						}).then((result) => {
									if (result.value) {

									window.location = "sales";

									}
								})

					</script>';
				}
			}
		}
	}

	/*=============================================
	Delete Sale
	=============================================*/

	static public function ctrDeleteSale()
	{

		if (isset($_GET["idSale"])) {

			$table = "sales";

			$item = "id";
			$value = $_GET["idSale"];

			$getSale = ModelSales::mdlShowSales($table, $item, $value);

			
			if($getSale["images"] != ""){

				$photos = json_decode($getSale["images"]);

				for ($i = 0; $i < count(array($photos)); $i++) {

					unlink($photos[$i]);
					rmdir('views/img/consultations/'.$getSale["code"]);
			    }
			}

			/*=============================================
			Delete Sale
			=============================================*/

			$answer = ModelSales::mdlDeleteSale($table, $_GET["idSale"]);

			if ($answer == "ok") {

				echo '<script>

				swal({
					  type: "success",
					  title: "The consultation and receipt has been deleted succesfully",	
					  showConfirmButton: true,
					  confirmButtonText: "Close",
					  closeOnConfirm: false
					  }).then((result) => {
								if (result.value) {

								window.location = "create-consultation";

								}
							})

				</script>';
			}
		}
	}

	/*=============================================
	DATES RANGE
	=============================================*/

	static public function ctrSalesDatesRange($initialDate, $finalDate)
	{

		$table = "sales";

		$answer = ModelSales::mdlSalesDatesRange($table, $initialDate, $finalDate);

		return $answer;
	}

	/*=============================================
	DOWNLOAD EXCEL
	=============================================*/

	public function ctrDownloadReport()
	{

		if (isset($_GET["report"])) {

			$table = "sales";

			if (isset($_GET["initialDate"]) && isset($_GET["finalDate"])) {

				$sales = ModelSales::mdlSalesDatesRange($table, $_GET["initialDate"], $_GET["finalDate"]);
			} else {

				$item = null;
				$value = null;

				$sales = ModelSales::mdlShowSales($table, $item, $value);
			}

			/*=============================================
			WE CREATE EXCEL FILE
			=============================================*/

			$name = $_GET["report"] . '.xls';

			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Excel file
			header("Cache-Control: cache, must-revalidate");
			header('Content-Description: File Transfer');
			header('Last-Modified: ' . date('D, d M Y H:i:s'));
			header("Pragma: public");
			header('Content-Disposition:; filename="' . $name . '"');
			header("Content-Transfer-Encoding: binary");

			echo utf8_decode("<table border='0'> 

					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>CÓDIGO</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>customer</td>
					<td style='font-weight:bold; border:1px solid #eee;'>Seller</td>
					<td style='font-weight:bold; border:1px solid #eee;'>quantity</td>
					<td style='font-weight:bold; border:1px solid #eee;'>products</td>
					<td style='font-weight:bold; border:1px solid #eee;'>tax</td>
					<td style='font-weight:bold; border:1px solid #eee;'>netPrice</td>		
					<td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>		
					<td style='font-weight:bold; border:1px solid #eee;'>METODO DE PAGO</td	
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>		
					</tr>");

			foreach ($sales as $row => $item) {

				$customer = ControllerCustomers::ctrShowCustomers("id", $item["idCustomer"]);
				$Seller = ControllerUsers::ctrShowUsers("id", $item["idSeller"]);

				echo utf8_decode("<tr>
			 			<td style='border:1px solid #eee;'>" . $item["code"] . "</td> 
			 			<td style='border:1px solid #eee;'>" . $customer["name"] . "</td>
			 			<td style='border:1px solid #eee;'>" . $Seller["name"] . "</td>
			 			<td style='border:1px solid #eee;'>");

				$products =  json_decode($item["products"], true);

				foreach ($products as $key => $valueproducts) {

					echo utf8_decode($valueproducts["quantity"] . "<br>");
				}

				echo utf8_decode("</td><td style='border:1px solid #eee;'>");

				foreach ($products as $key => $valueproducts) {

					echo utf8_decode($valueproducts["description"] . "<br>");
				}

				echo utf8_decode("</td>
					<td style='border:1px solid #eee;'>$ " . number_format($item["tax"], 2) . "</td>
					<td style='border:1px solid #eee;'>$ " . number_format($item["netPrice"], 2) . "</td>	
					<td style='border:1px solid #eee;'>$ " . number_format($item["totalPrice"], 2) . "</td>
					<td style='border:1px solid #eee;'>" . $item["paymentMethod"] . "</td>
					<td style='border:1px solid #eee;'>" . substr($item["saledate"], 0, 10) . "</td>		
		 			</tr>");
			}


			echo "</table>";
		}
	}


	/*=============================================
	Adding TOTAL sales
	=============================================*/

	public function ctrAddingTotalSales()
	{

		$table = "sales";

		$answer = ModelSales::mdlAddingTotalSales($table);

		return $answer;
	}


}
