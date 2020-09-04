<?php

require_once "../controllers/diagnosis.controller.php";
require_once "../models/diagnosis.model.php";

class AjaxDiagnosis{

	/*=============================================
	EDIT Diagnosis
	=============================================*/	

	public $idDiagnosis;

	public function ajaxEditDiagnosis(){

		$item = "id";
		$value = $this->diagnosisId;

		$answer = ControllerDiagnosis::ctrShowDiagnosis($item, $value);

		echo json_encode($answer);

	}

}

/*=============================================
EDIT Diagnosis
=============================================*/	

if(isset($_POST["diagnosisId"])){

	$Diagnosis = new AjaxDiagnosis();
	$Diagnosis -> diagnosisId = $_POST["diagnosisId"];
	$Diagnosis -> ajaxEditDiagnosis();

}