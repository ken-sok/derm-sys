<?php

class ControllerCustomers{

	/*=============================================
	CREATE CUSTOMERS
	=============================================*/

	static public function ctrCreateCustomer(){

		if(isset($_POST["newCustomer"])){

			if(preg_match('/^[a-zA-Z0-9ក-អ ]+$/', $_POST["newCustomer"]) &&
			   preg_match('/^[a-zA-Z]+$/', $_POST["newSex"]) &&
			   preg_match('/^[0-9]+$/', $_POST["newAge"])){

			   	$table = "customers";

			   	$data = array("name"=>$_POST["newCustomer"],
					           "phone"=>$_POST["newPhone"],
					           "sex"=>$_POST["newSex"],
							   "age"=>$_POST["newAge"], 
							   "medicalHis"=>$_POST["newMedicalHis"]);

			   	$answer = ModelCustomers::mdlAddCustomer($table, $data);

			   	if($answer == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "The patient has been saved",
						  showConfirmButton: true,
						  confirmButtonText: "Save"
						  }).then(function(result){
									if (result.value) {

									window.location = "create-consultation";

									}
								})

					</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "Patient information cannot be blank or special characters!",
						  showConfirmButton: true,
						  confirmButtonText: "Close"
						  }).then(function(result){
							if (result.value) {

							window.location = "customers";

							}
						})

			  	</script>';

			}

		}

	}

	/*=============================================
	SHOW CUSTOMERS
	=============================================*/

	static public function ctrShowCustomers($item, $value){

		$table = "customers";

		$answer = ModelCustomers::mdlShowCustomers($table, $item, $value);

		return $answer;

	}

	/*=============================================
	EDIT CUSTOMER
	=============================================*/

	static public function ctrEditCustomer(){

		if(isset($_POST["editCustomer"])){

			if(preg_match('/^[a-zA-Z0-9ក-អ ]+$/', $_POST["editCustomer"]) &&
			   preg_match('/^[a-zA-Z]+$/', $_POST["editSex"]) &&
			   preg_match('/^[0-9]+$/', $_POST["editAge"])){

			   	$table = "customers";

			   	$data = array("id"=>$_POST["idCustomer"],
			   				   "name"=>$_POST["editCustomer"],
					           "phone"=>$_POST["editPhone"],
					           "sex"=>$_POST["editSex"],
							   "age"=>$_POST["editAge"], 
							   "medicalHis"=>$_POST["editMedicalHis"]);



			   	$answer = ModelCustomers::mdlEditCustomer($table, $data);

			   	if($answer == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "The patient has been edited",
						  showConfirmButton: true,
						  confirmButtonText: "Close"
						  }).then(function(result){
									if (result.value) {

									window.location = "customers";

									}
								})

					</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "Patient cannot be blank or special characters",
						  showConfirmButton: true,
						  confirmButtonText: "Close"
						  }).then(function(result){
							if (result.value) {

							window.location = "customers";

							}
						})

			  	</script>';



			}

		}

	}

	/*=============================================
	DELETE CUSTOMER
	=============================================*/

	static public function ctrDeleteCustomer(){

		if(isset($_GET["idCustomer"])){

			$table ="customers";
			$data = $_GET["idCustomer"];

			$answer = ModelCustomers::mdlDeleteCustomer($table, $data);

			if($answer == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "The patient has been deleted",
					  showConfirmButton: true,
					  confirmButtonText: "Close"
					  }).then(function(result){
								if (result.value) {

								window.location = "customers";

								}
							})

				</script>';

			}		

		}

	}

}

