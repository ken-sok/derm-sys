/*=============================================
Phone Input mask
=============================================*/

$('input[name="newPhone"]').mask('(000) 000 0000');
$('input[name="editPhone"]').mask('(000) 000 0000');


/*=============================================
EDIT CUSTOMER
=============================================*/

$(".tables").on("click", "tbody .btnEditCustomer", function(){

	var idCustomer = $(this).attr("idCustomer");

	var datum = new FormData();
    datum.append("idCustomer", idCustomer);

    $.ajax({

      url:"ajax/customers.ajax.php",
      method: "POST",
      data: datum,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(answer){
      
      	 $("#idCustomer").val(answer["id"]);
	       $("#editCustomer").val(answer["name"]);
	       $("#editPhone").val(answer["phone"]);
	       $("#editSex").val(answer["sex"]);
         $("#editAge").val(answer["age"]);
         $("#editMedicalHis").val(answer["medicalHis"]);
	  }

  	})

})

/*=============================================
DELETE CUSTOMER
=============================================*/

$(".tables").on("click", "tbody .btnDeleteCustomer", function(){

	var idCustomer = $(this).attr("idCustomer");
	
	swal({
        title: 'Are you sure you want to delete this patient?',
        text: "If you're not sure, you can cancel the action!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'cancel',
        confirmButtonText: 'Yes, delete Patient!'
      }).then(function(result){
        if (result.value) {
            window.location = "index.php?route=customers&idCustomer="+idCustomer;
        }

  })

})