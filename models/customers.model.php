<?php

require_once "connection.php";

class ModelCustomers{

	/*=============================================
	CREATE CUSTOMERS
	=============================================*/

	static public function mdlAddCustomer($table, $data){

		$stmt = Connection::connect()->prepare("INSERT INTO $table(name, phone, age, sex, medicalHis) VALUES (:name, :phone, :age, :sex, :medicalHis)");

		$stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
		$stmt->bindParam(":phone", $data["phone"], PDO::PARAM_STR);
		$stmt->bindParam(":age", $data["age"], PDO::PARAM_STR);
		$stmt->bindParam(":sex", $data["sex"], PDO::PARAM_STR);
		$stmt->bindParam(":medicalHis", $data["medicalHis"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	SHOW CUSTOMERS
	=============================================*/

	static public function mdlShowCustomers($table, $item, $value){

		if($item != null){

			$stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $value, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Connection::connect()->prepare("SELECT * FROM $table");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	EDIT CUSTOMER
	=============================================*/

	static public function mdlEditCustomer($table, $data){

		$stmt = Connection::connect()->prepare("UPDATE $table SET name = :name, phone = :phone, age = :age, sex = :sex, medicalHis = :medicalHis WHERE id = :id");

		$stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);
		$stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
		$stmt->bindParam(":phone", $data["phone"], PDO::PARAM_STR);
		$stmt->bindParam(":age", $data["age"], PDO::PARAM_STR);
		$stmt->bindParam(":sex", $data["sex"], PDO::PARAM_STR);
		$stmt->bindParam(":medicalHis", $data["medicalHis"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	DELETE CUSTOMER
	=============================================*/

	static public function mdlDeleteCustomer($table, $data){

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
	UPDATE CUSTOMER
	=============================================*/

	static public function mdlUpdateCustomer($table, $item1, $value1, $value){

		$stmt = Connection::connect()->prepare("UPDATE $table SET $item1 = :$item1 WHERE id = :id");

		$stmt -> bindParam(":".$item1, $value1, PDO::PARAM_STR);
		$stmt -> bindParam(":id", $value, PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}
}
