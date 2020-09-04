/*=============================================
EDIT Diagnosis
=============================================*/

$(".DiagnosisTables").on("click", ".btnEditDiagnosis", function(){

  var diagnosisId = $(this).attr("diagnosisId");
  console.log(diagnosisId);

	var datum = new FormData();
	datum.append("diagnosisId", diagnosisId);

	$.ajax({
		url: "ajax/diagnosis.ajax.php",
		method: "POST",
    data: datum,
    cache: false,
    contentType: false,
    processData: false,
    dataType:"json",
    success: function(answer){
     		//console.log(answer);

     		$("#editDiagnosis").val(answer["name"]);
     		$("#diagnosisId").val(answer["id"]);

     	}

	})

})

/*=============================================
DELETE Diagnosis
=============================================*/
$(".DiagnosisTables").on("click", ".btnDeleteDiagnosis", function(){

   var diagnosisId = $(this).attr("diagnosisId");
   console.log(diagnosisId);

	 swal({
	 	title: 'Are you sure you want to delete the diagnosis?',
		text: "if you are not sure, you can cancel!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'Cancel',
		confirmButtonText: 'Yes, delete diagnosis!'
	 }).then(function(result){

	 	if(result.value){

	 		window.location = "index.php?route=diagnosis&diagnosisId="+diagnosisId;

	 	}

	 })

})