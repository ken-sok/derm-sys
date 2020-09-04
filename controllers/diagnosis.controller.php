<?php

class ControllerDiagnosis{

	/*=============================================
	CREATE diagnosis
	=============================================*/

	static public function ctrCreateDiagnosis(){

		if(isset($_POST["newDiagnosis"])){

			if(preg_match('/^[a-zA-Z0-9ក-អ ]+$/', $_POST["newDiagnosis"])){

			   	$table = "diagnosis";

			   	$data = array("name"=>$_POST["newDiagnosis"]); 

			   	$answer = ModelDiagnosis::mdlAddDiagnosis($table, $data);

			   	if($answer == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "The diagnosis has been saved",
						  showConfirmButton: true,
						  confirmButtonText: "Save"
						  }).then(function(result){
									if (result.value) {

									window.location = "create-sale";

									}
								})

					</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "diagnosis information cannot be blank or special characters!",
						  showConfirmButton: true,
						  confirmButtonText: "Close"
						  }).then(function(result){
							if (result.value) {

							window.location = "diagnosis";

							}
						})

			  	</script>';

			}

		}

	}

	/*=============================================
	SHOW diagnosis
	=============================================*/

	static public function ctrShowDiagnosis($item, $value){

		$table = "diagnosis";

		$answer = ModelDiagnosis::mdlShowDiagnosis($table, $item, $value);

		return $answer;

	}

	/*=============================================
	EDIT Diagnosis
	=============================================*/

	static public function ctrEditDiagnosis(){

		if(isset($_POST["editDiagnosis"])){

			if(preg_match('/^[a-zA-Z0-9ក-អ ]+$/', $_POST["editDiagnosis"])){

			   	$table = "diagnosis";

			   	$data = array("id"=>$_POST["diagnosisId"],
			   				   "name"=>$_POST["editDiagnosis"]); 


			   	$answer = ModelDiagnosis::mdlEditDiagnosis($table, $data);

			   	if($answer == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "The diagnosis has been edited",
						  showConfirmButton: true,
						  confirmButtonText: "Close"
						  }).then(function(result){
									if (result.value) {

									window.location = "diagnosis";

									}
								})

					</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "diagnosis cannot be blank or special characters",
						  showConfirmButton: true,
						  confirmButtonText: "Close"
						  }).then(function(result){
							if (result.value) {

							window.location = "diagnosis";

							}
						})

			  	</script>';



			}

		}

	}

	/*=============================================
	DELETE Diagnosis
	=============================================*/

	static public function ctrDeleteDiagnosis(){

		if(isset($_GET["diagnosisId"])){

			$table ="diagnosis";
			$data = $_GET["diagnosisId"];

			$answer = ModelDiagnosis::mdlDeleteDiagnosis($table, $data);

			if($answer == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "The diagnosis has been deleted",
					  showConfirmButton: true,
					  confirmButtonText: "Close"
					  }).then(function(result){
								if (result.value) {

								window.location = "diagnosis";

								}
							})

				</script>';

			}		

		}

	}

}

