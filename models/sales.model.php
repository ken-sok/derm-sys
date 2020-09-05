<?php

require_once 'connection.php';


class ModelSales{
	/*=============================================
	SHOWING SALES
	=============================================*/


	static public function mdlShowSales($table, $item, $value){

		if($item != null){

			$stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE $item = :$item ORDER BY id DESC");

			$stmt -> bindParam(":".$item, $value, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Connection::connect()->prepare("SELECT * FROM $table ORDER BY id DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	REGISTERING SALE
	=============================================*/

	static public function mdlAddSale($table, $data){

		$stmt = Connection::connect()->prepare("INSERT INTO $table(code, idCustomer, products, receipt, totalPrice, comment, diagnosis) VALUES (:code, :idCustomer, :products, :receipt, :totalPrice, :comment, :diagnosis)");

		$stmt->bindParam(":code", $data["code"], PDO::PARAM_INT);
		$stmt->bindParam(":idCustomer", $data["idCustomer"], PDO::PARAM_INT);
		$stmt->bindParam(":products", $data["products"], PDO::PARAM_STR);
		$stmt->bindParam(":receipt", $data["receipt"], PDO::PARAM_STR);
		$stmt->bindParam(":totalPrice", $data["totalPrice"], PDO::PARAM_STR);
		$stmt->bindParam(":comment", $data["comment"], PDO::PARAM_STR);
		$stmt->bindParam(":diagnosis", $data["diagnosis"], PDO::PARAM_STR);
		
		

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	EDIT SALE
	=============================================*/

	static public function mdlEditSale($table, $data){

		$stmt = Connection::connect()->prepare("UPDATE $table SET  idCustomer = :idCustomer, products = :products, receipt =:receipt, totalPrice= :totalPrice, comment = :comment, diagnosis = :diagnosis WHERE code = :code");

		$stmt->bindParam(":code", $data["code"], PDO::PARAM_INT);
		$stmt->bindParam(":idCustomer", $data["idCustomer"], PDO::PARAM_INT);
		$stmt->bindParam(":products", $data["products"], PDO::PARAM_STR);
		$stmt->bindParam(":receipt", $data["receipt"], PDO::PARAM_STR);
		$stmt->bindParam(":totalPrice", $data["totalPrice"], PDO::PARAM_STR);
		$stmt->bindParam(":comment", $data["comment"], PDO::PARAM_STR);
		$stmt->bindParam(":diagnosis", $data["diagnosis"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	DELETE SALE
	=============================================*/

	static public function mdlDeleteSale($table, $data){

		$stmt = Connection::connect()->prepare("DELETE FROM $table WHERE id = :id");

		$stmt -> bindParam(":id", $data, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	DATES RANGE
	=============================================*/	

	static public function mdlSalesDatesRange($table, $initialDate, $finalDate){

		if($initialDate == null){

			$stmt = Connection::connect()->prepare("SELECT * FROM $table ORDER BY id DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();	


		}else if($initialDate == $finalDate){

			$stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE saledate like '%$finalDate%'");

			$stmt -> bindParam(":saledate", $finalDate, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{

			$actualDate = new DateTime();
			$actualDate ->add(new DateInterval("P1D"));
			$actualDatePlusOne = $actualDate->format("Y-m-d");

			$finalDate2 = new DateTime($finalDate);
			$finalDate2 ->add(new DateInterval("P1D"));
			$finalDatePlusOne = $finalDate2->format("Y-m-d");

			if($finalDatePlusOne == $actualDatePlusOne){

				$stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE saledate BETWEEN '$initialDate' AND '$finalDatePlusOne'");

			}else{


				$stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE saledate BETWEEN '$initialDate' AND '$finalDate'");

			}
		
			$stmt -> execute();

			return $stmt -> fetchAll();

		}

	}


	/*=============================================
	Adding TOTAL sales
	=============================================*/

	static public function mdlAddingTotalSales($table){	

		$stmt = Connection::connect()->prepare("SELECT SUM(netPrice) as total FROM $table");

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}
}