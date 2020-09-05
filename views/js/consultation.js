/*=============================================
LOAD DYNAMIC PRODUCTS TABLE
=============================================*/

// $.ajax({

// 	url: "ajax/datatable-products.ajax.php",
// 	success:function(answer){
		
// 		console.log("answer", answer);

// 	}

// })

//list products for edit
//test for delete all products
listProducts(); 

$('.consultationTable').DataTable({
	"ajax": "ajax/datatable-consultation.ajax.php", 
	"deferRender": true,
	"retrieve": true,
	"processing": true
});



/*=============================================
ADDING PRODUCTS TO THE SALE FROM THE TABLE
=============================================*/

$(".consultationTable tbody ").on("click", "button.addProductSale", function(){


	var idProduct = $(this).attr("idProduct");

	$(this).removeClass("btn-primary addProductSale");

	$(this).addClass("btn-default");

	var datum = new FormData();
    datum.append("idProduct", idProduct);

     $.ajax({

     	url:"ajax/products.ajax.php",
      	method: "POST",
      	data: datum,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(answer){

      	    var description = answer["description"];
          	var stock = answer["stock"];
			var price = answer["sellingPrice"];
			


          	/*=============================================
          	AVOID ADDING THE PRODUCT WHEN ITS STOCK IS ZERO
          	

			
          	if(stock == 0){

      			swal({
			      title: "There's no stock available",
			      type: "error",
			      confirmButtonText: "Close"
			    });

			    
			    $("button[idProduct='"+idProduct+"']").addClass("btn-primary addProductSale");

			    return;

			  }
			  =============================================*/

          	$(".newProduct").append(

          	'<div class="row" style="padding:5px 15px">'+

			  '<!-- Product description -->'+
	          
	          '<div class="col-xs-6" style="padding-right:0px">'+
	          
	            '<div class="input-group">'+
	              
	              '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs removeProduct" idProduct="'+idProduct+'"><i class="fa fa-times"></i></button></span>'+

	              '<input type="text" class="form-control newProductDescription" idProduct="'+idProduct+'" name="addProductSale" value="'+description+'" readonly required>'+

	            '</div>'+

	          '</div>'+

	          '<!-- Product quantity -->'+

	          '<div class="col-xs-3 enterQuantity">'+
	            
	             '<input type="number" class="form-control newProductQuantity" name="newProductQuantity" min="1" value="1" stock="'+stock+'" newStock="'+Number(stock-1)+'" required>'+

			  '</div>' +
			  
			  '<!-- product usage -->'+

	          '<div class="col-xs-3 enterUsage" style="padding-left:0px;">'+

	            '<div class="input-group">'+

	              '<span class="input-group-addon"><i class="fa fa-repeat"></i></span>'+
	                 
	              '<input type="text" class="form-control newProductUsage" idProduct="'+idProduct+'" name="addProductUsage" usage="" required>'+
	 
	            '</div>'+
	             
	          '</div>'+

	          '<!-- product price -->'+

	          '<div class="col-xs-3 enterPrice" style="visibility: hidden;">'+

	            '<div class="input-group">'+

	              '<input type="hidden" class="form-control newProductPrice" realPrice="'+price+'" name="newProductPrice" value="'+price+'" readonly required>'+
	 
	            '</div>'+
	             
			  '</div>'+
			  



	        '</div>')

	        // ADDING TOTAL PRICES

	    	addingTotalPrices()


	        // GROUP PRODUCTS IN JSON FORMAT

	        listProducts()

	        // FORMAT PRODUCT PRICE

	        $(".newProductPrice").number(true, 2);

      	}

     })

});

/*=============================================
WHEN TABLE LOADS EVERYTIME THAT NAVIGATE IN IT
=============================================*/

$(".consultationTable").on("draw.dt", function(){

	if(localStorage.getItem("removeProduct") != null){

		var listIdProducts = JSON.parse(localStorage.getItem("removeProduct"));

		for(var i = 0; i < listIdProducts.length; i++){

			$("button.recoverButton[idProduct='"+listIdProducts[i]["idProduct"]+"']").removeClass('btn-default');
			$("button.recoverButton[idProduct='"+listIdProducts[i]["idProduct"]+"']").addClass('btn-primary addProductSale');

		}


	}


})

/*=============================================
REMOVE PRODUCTS FROM THE SALE AND RECOVER BUTTON
=============================================*/

var idRemoveProduct = [];

localStorage.removeItem("removeProduct");

$(".consultationForm").on("click", "button.removeProduct", function(){

	console.log("$(this)", $(this));
	$(this).parent().parent().parent().parent().remove();

	var idProduct = $(this).attr("idProduct");
	console.log("idProduct", idProduct);
	

	/*=============================================
	STORE IN LOCALSTORAGE THE ID OF THE PRODUCT WE WANT TO DELETE
	=============================================*/

	if(localStorage.getItem("removeProduct") == null){

		idRemoveProduct = [];
	
	}else{

		idRemoveProduct.concat(localStorage.getItem("removeProduct"))

	}

	idRemoveProduct.push({"idProduct":idProduct});

	localStorage.setItem("removeProduct", JSON.stringify(idRemoveProduct));

	$("button.recoverButton[idProduct='"+idProduct+"']").removeClass('btn-default');

	$("button.recoverButton[idProduct='"+idProduct+"']").addClass('btn-primary addProductSale');

	if($(".newProduct").children().length == 0){

		 
		$("#newSaleTotal").val(0);
		$("#saleTotal").val(0);
		$("#newSaleTotal").attr("totalSale",0);



        // GROUP PRODUCTS IN JSON FORMAT

        listProducts()


	}else{

		// ADDING TOTAL PRICES
		
    	addingTotalPrices()

        // GROUP PRODUCTS IN JSON FORMAT

        listProducts()

	}

})




/*=============================================
SELECT PRODUCT
=============================================*/

$(".consultationForm").on("change", "select.newProductDescription", function(){

	var productName = $(this).val();

	var newProductDescription = $(this).parent().parent().parent().children().children().children(".newProductDescription");

	var newProductPrice = $(this).parent().parent().parent().children(".enterPrice").children().children(".newProductPrice");

	var newProductQuantity = $(this).parent().parent().parent().children(".enterQuantity").children(".newProductQuantity");

	var datum = new FormData();
    datum.append("productName", productName);


	  $.ajax({

     	url:"ajax/products.ajax.php",
      	method: "POST",
      	data: datum,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(answer){
      	    
      	    $(newProductDescription).attr("idProduct", answer["id"]);
      	    $(newProductQuantity).attr("stock", answer["stock"]);
      	    $(newProductQuantity).attr("newStock", Number(answer["stock"])-1);
      	    $(newProductPrice).val(answer["sellingPrice"]);
      	    $(newProductPrice).attr("realPrice", answer["sellingPrice"]);

  	      // GROUP PRODUCTS IN JSON FORMAT

	        listProducts()

      	}

      })
})

/*=============================================
MODIFY QUANTITY
=============================================*/

$(".consultationForm").on("change", "input.newProductQuantity", function(){

	var price = $(this).parent().parent().children(".enterPrice").children().children(".newProductPrice");

	var finalPrice = $(this).val() * price.attr("realPrice");
	
	price.val(finalPrice);

	var newStock = Number($(this).attr("stock")) - $(this).val();

	$(this).attr("newStock", newStock);

	console.log("$(this).attr(\"stock\")", $(this).attr("stock"));
	if(Number($(this).val()) > Number($(this).attr("stock"))){

		/*=============================================
		IF QUANTITY IS MORE THAN THE STOCK VALUE SET INITIAL VALUES
		=============================================*/

		$(this).val(1);

		var finalPrice = $(this).val() * price.attr("realPrice");

		price.val(finalPrice);

		addingTotalPrices();

		swal({
	      title: "The quantity is more than your stock",
	      text: "There's only"+$(this).attr("stock")+" units!",
	      type: "error",
	      confirmButtonText: "Close!"
	    });

	    return;

	}

	// ADDING TOTAL PRICES

	addingTotalPrices()


    // GROUP PRODUCTS IN JSON FORMAT

    listProducts()

})


/*=============================================
MODIFY FREQUENCY OF USE
=============================================*/

$(".consultationForm").on("change", "input.newProductUsage", function(){

	var usage = $(this).val();
	
	$(this).attr("usage", $(this).val()); 

	listProducts();
	
})


/*============================================
PRICES ADDITION
=============================================*/

function addingTotalPrices(){

	var priceItem = $(".newProductPrice");
	var arrayAdditionPrice = [];  

	for(var i = 0; i < priceItem.length; i++){

		 arrayAdditionPrice.push(Number($(priceItem[i]).val()));
		 
	}

	function additionArrayPrices(totalSale, numberArray){

		return totalSale + numberArray;

	}



	var addingTotalPrice = arrayAdditionPrice.reduce(additionArrayPrices);

	//addingTotalPrice = round(addingTotalPrice);
	
	$("#newSaleTotal").val(addingTotalPrice);
	$("#saleTotal").val(addingTotalPrice);
	$("#newSaleTotal").attr("totalSale",addingTotalPrice);

	
}

/*=============================================
FINAL PRICE FORMAT
=============================================*/

$("#newSaleTotal").number(true, 2);


/*=============================================
CASH CHANGE
=============================================*/
$(".consultationForm").on("change", "input#newCashValue", function(){

	
	var cash = $(this).val();
	console.log("cash", cash);

	var change =  Number(cash) - Number($('#saleTotal').val());
	console.log("change", change);

	var newCashChange = $(this).parent().parent().parent().children('#getCashChange').children().children('#newCashChange');

	newCashChange.val(change);

})

/*=============================================
CHANGE TRANSACTION CODE
=============================================*/
$(".consultationForm").on("change", "input#newTransactionCode", function(){

	// List method in the entry
     listMethods()


})


/*=============================================
LIST ALL THE PRODUCTS
=============================================*/

function listProducts(){

	var productsList = [];

	var description = $(".newProductDescription");

	var quantity = $(".newProductQuantity");

	var price = $(".newProductPrice");

	//var note = $(".newNotes");

	var usage = $(".newProductUsage");

	for(var i = 0; i < description.length; i++){

		productsList.push({ "id" : $(description[i]).attr("idProduct"), 
							  "description" : $(description[i]).val(),
							  "usage" : $(usage[i]).attr("usage"),
							  "quantity" : $(quantity[i]).val(),
							  "stock" : $(quantity[i]).attr("newStock"),
							  "price" : $(price[i]).attr("realPrice"),
							  "totalPrice" : $(price[i]).val()})
	}

	$("#productsList").val(JSON.stringify(productsList)); 

	console.log("products list", productsList)

}



/*=============================================
EDIT SALE BUTTON
=============================================*/
$(".tables").on("click", ".btnEditConsultation", function(){

	var idSale = $(this).attr("idSale");

	window.location = "index.php?route=edit-consultation&idSale="+idSale;


})

/*=============================================
FUNCTION TO DEACTIVATE "ADD" BUTTONS WHEN THE PRODUCT HAS BEEN SELECTED IN THE FOLDER
=============================================*/

function removeAddProductSale(){

	//We capture all the products' id that were selected in the sale
	var idProducts = $(".removeProduct");

	//We capture all the buttons to add that appear in the table
	var tableButtons = $(".consultationTable tbody button.addProductSale");

	//We navigate the cycle to get the different idProducts that were added to the sale
	for(var i = 0; i < idProducts.length; i++){

		//We capture the IDs of the products added to the sale
		var button = $(idProducts[i]).attr("idProduct");
		
		//We go over the table that appears to deactivate the "add" buttons
		for(var j = 0; j < tableButtons.length; j ++){

			if($(tableButtons[j]).attr("idProduct") == button){

				$(tableButtons[j]).removeClass("btn-primary addProductSale");
				$(tableButtons[j]).addClass("btn-default");

			}
		}

	}
	
}

/*=============================================
EVERY TIME THAT THE TABLE IS LOADED WHEN WE NAVIGATE THROUGH IT EXECUTES A FUNCTION
=============================================*/

$('.consultationTable').on( 'draw.dt', function(){

	removeAddProductSale();

})



/*=============================================
DELETE SALE
=============================================*/
$(".tables").on("click", ".btnDeleteSale", function(){

  var idSale = $(this).attr("idSale");

  swal({
        title: 'Are you sure you want to delete the consultation?',
        text: "If you're not you can cancel!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancel',
        confirmButtonText: 'Yes, delete consultation!'
      }).then(function(result){
        if (result.value) {
          
            window.location = "index.php?route=sales&idSale="+idSale;
        }

  })

})

/*=============================================
PRINT BILL
=============================================*/

$(".tables").on("click", ".btnPrintBill", function(){

	var saleCode = $(this).attr("saleCode");

	window.open("extensions/receipt/receipt.php?code="+saleCode, "_blank");

})


/*=============================================
DATES RANGE
=============================================*/

$('#daterange-btn').daterangepicker(
  {
    ranges   : {
      'Today'       : [moment(), moment()],
      'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Last 7 days' : [moment().subtract(6, 'days'), moment()],
      'Last 30 days': [moment().subtract(29, 'days'), moment()],
      'this month'  : [moment().startOf('month'), moment().endOf('month')],
      'Last month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    startDate: moment(),
    endDate  : moment()
  },
  function (start, end) {
    $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

    var initialDate = start.format('YYYY-MM-DD');

    var finalDate = end.format('YYYY-MM-DD');

    var captureRange = $("#daterange-btn span").html();
   
   	localStorage.setItem("captureRange", captureRange);
   	console.log("localStorage", localStorage);

   	window.location = "index.php?route=sales&initialDate="+initialDate+"&finalDate="+finalDate;

  }

)

/*=============================================
CANCEL DATES RANGE
=============================================*/

$(".daterangepicker.opensleft .range_inputs .cancelBtn").on("click", function(){

	localStorage.removeItem("captureRange");
	localStorage.clear();
	window.location = "sales";
})

/*=============================================
CAPTURE TODAY'S BUTTON
=============================================*/

$(".daterangepicker.opensleft .ranges li").on("click", function(){

	var todayButton = $(this).attr("data-range-key");

	if(todayButton == "Today"){

		var d = new Date();
		
		var day = d.getDate();
		var month= d.getMonth()+1;
		var year = d.getFullYear();

		if(month < 10){

			var initialDate = year+"-0"+month+"-"+day;
			var finalDate = year+"-0"+month+"-"+day;

		}else if(day < 10){

			var initialDate = year+"-"+month+"-0"+day;
			var finalDate = year+"-"+month+"-0"+day;

		}else if(month < 10 && day < 10){

			var initialDate = year+"-0"+month+"-0"+day;
			var finalDate = year+"-0"+month+"-0"+day;

		}else{

			var initialDate = year+"-"+month+"-"+day;
	    	var finalDate = year+"-"+month+"-"+day;

		}	

    	localStorage.setItem("captureRange", "Today");

    	window.location = "index.php?route=sales&initialDate="+initialDate+"&finalDate="+finalDate;

	}

})

/*=============================================
OPEN XML FILE IN A NEW TAB
=============================================*/

$(".openXML").click(function(){

	var file = $(this).attr("file");
	window.open(file, "_blank");


})

/*=============================================
select appointment date
=============================================*/

$(function() {
	$( "#datepicker-1" ).datepicker(
		{ dateFormat: "yy-mm-dd" }
	);
	
});

