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

$(".consultationTable").DataTable({
	ajax: "ajax/datatable-consultation.ajax.php",
	deferRender: true,
	retrieve: true,
	processing: true,
});

/*=============================================
ADDING PRODUCTS TO THE SALE FROM THE TABLE
=============================================*/

$(".consultationTable tbody ").on(
	"click",
	"button.addProductSale",
	function () {
		var idProduct = $(this).attr("idProduct");

		$(this).removeClass("btn-primary addProductSale");

		$(this).addClass("btn-default");

		var datum = new FormData();
		datum.append("idProduct", idProduct);

		$.ajax({
			url: "ajax/products.ajax.php",
			method: "POST",
			data: datum,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function (answer) {
				var description = answer["description"];

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
					'<div class="row" style="padding:5px 15px">' +

					"<!-- Product description -->" +
					'<div class="col-xs-5" style="padding-right:0px">' +
						'<div class="input-group">' +
							'<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs removeProduct" idProduct="' +
							idProduct +
							'"><i class="fa fa-times"></i></button></span>' +
							'<input type="text" class="form-control newProductDescription" idProduct="' +
							idProduct +
							'" name="addProductSale" value="' +
							description +
							'" readonly required>' +
						"</div>" +
					"</div>" +


					"<!-- Product quantity -->" +
					'<div class="col-xs-2 enterQuantity">' +
					'<input type="number" class="form-control newProductQuantity" name="newProductQuantity" min="1" value="1" required>' +
					"</div>" +


					"<!-- Product scale -->" +
					'<div class="col-xs-5 enterScale">' +
						'<input type="text" class="form-control newProductScale" name="newProductScale" idProduct="' +
						idProduct +
						'" scale="" required>' +
					"</div>" +

					
					"<!-- product price -->" +
					'<div class="col-xs-3 enterPrice" style="visibility: hidden;">' +
					'<div class="input-group">' +
					'<input type="hidden" class="form-control newProductPrice" realPrice="' +
					price +
					'" name="newProductPrice" value="' +
					price +
					'" readonly required>' +
					"</div>" +
					"</div>" +

					"</div>" +
					"<!-- product usage -->" +
					'<div class="row" style="padding:5px 15px">' +
					'<div class="col-xs-8 enterUsage" style="padding-right:0px">' +
					'<div class="input-group">' +
					'<span class="input-group-addon"><i class="fa fa-repeat"></i></span>' +
					'<input type="text" class="form-control newProductUsage" idProduct="' +
					idProduct +
					'" name="addProductUsage" usage="" required>' +
					"</div>" +
					"</div>" +
					"</div>"
				);

				// ADDING TOTAL PRICES

				addingTotalPrices();

				// GROUP PRODUCTS IN JSON FORMAT

				listProducts();

				// FORMAT PRODUCT PRICE

				$(".newProductPrice").number(true, 2);
			},
		});
	}
);

/*=============================================
ADDING PRODUCT FROM A DEVICE
=============================================*/

var numProduct = 0;

$(".btnAddProductConsult").click(function () {
	numProduct++;

	var datum = new FormData();
	datum.append("getProducts", "ok");

	$.ajax({
		url: "ajax/products.ajax.php",
		method: "POST",
		data: datum,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (answer) {
			$(".newProduct").append(
				'<div class="row" style="padding:5px 15px">'+

			  '<!-- Product description -->'+
	          
	          '<div class="col-xs-5" style="padding-right:0px">'+
	          
	            '<div class="input-group">'+
	              
	              '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs removeProduct" idProduct><i class="fa fa-times"></i></button></span>'+

	              '<select class="form-control newProductDescription" id="product'+numProduct+'" idProduct name="newProductDescription" required>'+

	              '<option>Select product</option>'+

	              '</select>'+  

	            '</div>'+

	          '</div>'+

	          '<!-- Product quantity -->'+

	          '<div class="col-xs-2 enterQuantity">'+
	            
	             '<input type="number" class="form-control newProductQuantity" name="newProductQuantity" min="1" value="1" stock newStock required>'+

			  '</div>' +
			  
			  
			  "<!-- Product scale -->" +
			  '<div class="col-xs-5 enterScale">' +
				  '<input type="text" class="form-control newProductScale" name="newProductScale" scale="" id="product'+numProduct+'" idProduct' +
				  '" required>' +

			  "</div>" +

	          '<!-- Product price -->'+

	          '<div class="col-xs-3 enterPrice" style="display: none;">'+

	            '<div class="input-group">'+

	              '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+
	                 
	              '<input type="text" class="form-control newProductPrice" realPrice="" name="newProductPrice" readonly required>'+
	 
	            '</div>'+
	             
	          '</div>'+

			'</div>' +
			
			
			"<!-- product usage -->" +
					'<div class="row" style="padding:5px 15px">' +
					'<div class="col-xs-8 enterUsage" style="padding-right:0px">' +
					'<div class="input-group">' +
					'<span class="input-group-addon"><i class="fa fa-repeat"></i></span>' +
					'<input type="text" class="form-control newProductUsage" id="product'+numProduct+'" idProduct' +
					'" name="addProductUsage" usage="" required>' +
					"</div>" +
					"</div>" +
					"</div>");


			// ADDING PRODUCTS TO THE SELECT

			answer.forEach(functionForEach);

			function functionForEach(item, index) {
				
					$("#product" + numProduct).append(
						'<option idProduct="' +
						item.id +
						'" value="' +
						item.description +
						'">' +
						item.description +
						"</option>"
					);
				
			}

			// ADDING TOTAL PRICES

			addingTotalPrices();


			// SET FORMAT TO THE PRODUCT PRICE

			$(".newProductPrice").number(true, 2);
		},
	});
});

/*=============================================
WHEN TABLE LOADS EVERYTIME THAT NAVIGATE IN IT
=============================================*/

$(".consultationTable").on("draw.dt", function () {
	if (localStorage.getItem("removeProduct") != null) {
		var listIdProducts = JSON.parse(localStorage.getItem("removeProduct"));

		for (var i = 0; i < listIdProducts.length; i++) {
			$(
				"button.recoverButton[idProduct='" +
				listIdProducts[i]["idProduct"] +
				"']"
			).removeClass("btn-default");
			$(
				"button.recoverButton[idProduct='" +
				listIdProducts[i]["idProduct"] +
				"']"
			).addClass("btn-primary addProductSale");
		}
	}
});

/*=============================================
REMOVE PRODUCTS FROM THE SALE AND RECOVER BUTTON
=============================================*/

var idRemoveProduct = [];

localStorage.removeItem("removeProduct");

$(".consultationForm").on("click", "button.removeProduct", function () {
	//console.log("$(this)", $(this));
	$(this).parent().parent().parent().parent().next().remove();
	$(this).parent().parent().parent().parent().remove();

	var idProduct = $(this).attr("idProduct");
	console.log("idProduct", idProduct);

	/*=============================================
	  STORE IN LOCALSTORAGE THE ID OF THE PRODUCT WE WANT TO DELETE
	  =============================================*/

	if (localStorage.getItem("removeProduct") == null) {
		idRemoveProduct = [];
	} else {
		idRemoveProduct.concat(localStorage.getItem("removeProduct"));
	}

	idRemoveProduct.push({ idProduct: idProduct });

	localStorage.setItem("removeProduct", JSON.stringify(idRemoveProduct));

	$("button.recoverButton[idProduct='" + idProduct + "']").removeClass(
		"btn-default"
	);

	$("button.recoverButton[idProduct='" + idProduct + "']").addClass(
		"btn-primary addProductSale"
	);

	if ($(".newProduct").children().length == 0) {
		$("#newSaleTotal").val(0);
		$("#saleTotal").val(0);
		$("#newSaleTotal").attr("totalSale", 0);

		// GROUP PRODUCTS IN JSON FORMAT

		listProducts();
	} else {
		// ADDING TOTAL PRICES

		addingTotalPrices();

		// GROUP PRODUCTS IN JSON FORMAT

		listProducts();
	}
});

/*=============================================
SELECT PRODUCT
=============================================*/

$(".consultationForm").on(
	"change",
	"select.newProductDescription",
	function () {
		var productName = $(this).val();

		var newProductDescription = $(this)
			.parent()
			.parent()
			.parent()
			.children()
			.children()
			.children(".newProductDescription");

		var newProductPrice = $(this)
			.parent()
			.parent()
			.parent()
			.children(".enterPrice")
			.children()
			.children(".newProductPrice");

		var newProductQuantity = $(this)
			.parent()
			.parent()
			.parent()
			.children(".enterQuantity")
			.children(".newProductQuantity");

		var datum = new FormData();
		datum.append("productName", productName);

		$.ajax({
			url: "ajax/products.ajax.php",
			method: "POST",
			data: datum,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function (answer) {
				$(newProductDescription).attr("idProduct", answer["id"]);
				$(newProductQuantity).attr("stock", answer["stock"]);
				$(newProductQuantity).attr("newStock", Number(answer["stock"]) - 1);
				$(newProductPrice).val(answer["sellingPrice"]);
				$(newProductPrice).attr("realPrice", answer["sellingPrice"]);

				// GROUP PRODUCTS IN JSON FORMAT

				listProducts();
			},
		});
	}
);

/*=============================================
MODIFY QUANTITY
=============================================*/

$(".consultationForm").on("change", "input.newProductQuantity", function () {
	var price = $(this)
		.parent()
		.parent()
		.children(".enterPrice")
		.children()
		.children(".newProductPrice");

	var finalPrice = $(this).val() * price.attr("realPrice");

	price.val(finalPrice);

	var newStock = Number($(this).attr("stock")) - $(this).val();

	$(this).attr("newStock", newStock);

	console.log('$(this).attr("stock")', $(this).attr("stock"));
	if (Number($(this).val()) > Number($(this).attr("stock"))) {
		/*=============================================
			IF QUANTITY IS MORE THAN THE STOCK VALUE SET INITIAL VALUES
			
	
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
			*/
	}

	// ADDING TOTAL PRICES

	addingTotalPrices();

	// GROUP PRODUCTS IN JSON FORMAT

	listProducts();
});

/*=============================================
MODIFY FREQUENCY OF USE
=============================================*/

$(".consultationForm").on("change", "input.newProductUsage", function () {
	//var usage = $(this).val();

	$(this).attr("usage", $(this).val());

	listProducts();
});


/*=============================================
MODIFY SCALE OF MEDS
=============================================*/

$(".consultationForm").on("change", "input.newProductScale", function () {
	//var scale = $(this).val();

	$(this).attr("scale", $(this).val());

	listProducts();
});
/*============================================
PRICES ADDITION
=============================================*/

function addingTotalPrices() {
	var priceItem = $(".newProductPrice");
	var arrayAdditionPrice = [];

	for (var i = 0; i < priceItem.length; i++) {
		arrayAdditionPrice.push(Number($(priceItem[i]).val()));
	}

	function additionArrayPrices(totalSale, numberArray) {
		return totalSale + numberArray;
	}

	var addingTotalPrice = arrayAdditionPrice.reduce(additionArrayPrices);

	//addingTotalPrice = round(addingTotalPrice);

	$("#newSaleTotal").val(addingTotalPrice);
	$("#saleTotal").val(addingTotalPrice);
	$("#newSaleTotal").attr("totalSale", addingTotalPrice);

	console.log("here in consult");
	var rate = $("#moneyRate").val();
  
	var totalSale = $("#newSaleTotal").val();
  
	var converted = rate*totalSale;
  
	//console.log('converted separtor', thousands_separators(converted));
	$("#newSaleTotalKH").val(thousands_separators(converted));
	$("#saleTotalKH").val(converted);
	$("#newSaleTotalKH").attr("totalSaleKH", converted);
}

/*=============================================
FINAL PRICE FORMAT
=============================================*/

$("#newSaleTotal").number(true, 2);

/*=============================================
CASH CHANGE
=============================================*/
$(".consultationForm").on("change", "input#newCashValue", function () {
	var cash = $(this).val();
	console.log("cash", cash);

	var change = Number(cash) - Number($("#saleTotal").val());
	console.log("change", change);

	var newCashChange = $(this)
		.parent()
		.parent()
		.parent()
		.children("#getCashChange")
		.children()
		.children("#newCashChange");

	newCashChange.val(change);
});

/*=============================================
CHANGE TRANSACTION CODE
=============================================*/
$(".consultationForm").on("change", "input#newTransactionCode", function () {
	// List method in the entry
	listMethods();
});

/*=============================================
LIST ALL THE PRODUCTS
=============================================*/

function listProducts() {
	var productsList = [];

	var description = $(".newProductDescription");

	var quantity = $(".newProductQuantity");

	var price = $(".newProductPrice");

	//var note = $(".newNotes");

	var usage = $(".newProductUsage");

	var scale = $(".newProductScale"); 

	for (var i = 0; i < description.length; i++) {
		productsList.push({
			id: $(description[i]).attr("idProduct"),
			description: $(description[i]).val(),
			usage: $(usage[i]).attr("usage"),
			quantity: $(quantity[i]).val(),
			scale: $(scale[i]).attr("scale"),
			price: $(price[i]).attr("realPrice"),
			totalPrice: $(price[i]).val(),
		});
	}

	$("#productsList").val(JSON.stringify(productsList));

	console.log("products list", productsList);
}

/*=============================================
EDIT CONSULT BUTTON
=============================================*/
$(".tables").on("click", ".btnEditConsultation", function () {
	var idSale = $(this).attr("idSale");

	window.location = "index.php?route=edit-consultation&idSale=" + idSale;

});

/*=============================================
FUNCTION TO DEACTIVATE "ADD" BUTTONS WHEN THE PRODUCT HAS BEEN SELECTED IN THE FOLDER
=============================================*/

function removeAddProductSale() {
	//We capture all the products' id that were selected in the sale
	var idProducts = $(".removeProduct");

	//We capture all the buttons to add that appear in the table
	var tableButtons = $(".consultationTable tbody button.addProductSale");

	//We navigate the cycle to get the different idProducts that were added to the sale
	for (var i = 0; i < idProducts.length; i++) {
		//We capture the IDs of the products added to the sale
		var button = $(idProducts[i]).attr("idProduct");

		//We go over the table that appears to deactivate the "add" buttons
		for (var j = 0; j < tableButtons.length; j++) {
			if ($(tableButtons[j]).attr("idProduct") == button) {
				$(tableButtons[j]).removeClass("btn-primary addProductSale");
				$(tableButtons[j]).addClass("btn-default");
			}
		}
	}
}

/*=============================================
EVERY TIME THAT THE TABLE IS LOADED WHEN WE NAVIGATE THROUGH IT EXECUTES A FUNCTION
=============================================*/

$(".consultationTable").on("draw.dt", function () {
	removeAddProductSale();
});

/*=============================================
SEARCH CUSTOMER HISTORY SALE
=============================================*/

$(".tables").on("click", ".btnCusHistory", function () {
	var cusName = $(this).attr("cusName");
	console.log(cusName);

	//put into search bar
	document.getElementsByTagName("input")[0].value = cusName[0];
	document.getElementsByTagName("input")[0].value = cusName;
});

/*=============================================
DELETE SALE
=============================================*/
$(".tables").on("click", ".btnDeleteConsultation", function () {
	var idSale = $(this).attr("idSale");

	swal({
		title: "Are you sure you want to delete the consultation and receipt?",
		text: "If you're not you can cancel!",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		cancelButtonText: "Cancel",
		confirmButtonText: "Yes, delete all!",
	}).then(function (result) {
		if (result.value) {
			window.location = "index.php?route=consultation&idSale=" + idSale;
		}
	});
});

/*=============================================
PRINT BILL
=============================================*/

$(".tables").on("click", ".btnPrintConsult", function () {
	var saleCode = $(this).attr("saleCode");
	//should change this to consult.php
	//window.open("extensions/receipt/receipt.php?code=" + saleCode, "_blank");
	window.open("extensions/tcpdf/examples/example_001.php", "_blank");
});

/*=============================================
DATES RANGE
=============================================*/

$("#daterange-btn-consult").daterangepicker(
	{
		ranges: {
			Today: [moment(), moment()],
			Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
			"Last 7 days": [moment().subtract(6, "days"), moment()],
			"Last 30 days": [moment().subtract(29, "days"), moment()],
			"this month": [moment().startOf("month"), moment().endOf("month")],
			"Last month": [
				moment().subtract(1, "month").startOf("month"),
				moment().subtract(1, "month").endOf("month"),
			],
		},
		startDate: moment(),
		endDate: moment(),
	},
	function (start, end) {
		$("#daterange-btn-consult span").html(
			start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY")
		);

		var initialDate = start.format("YYYY-MM-DD");

		var finalDate = end.format("YYYY-MM-DD");

		var captureRange = $("#daterange-btn-consult span").html();

		localStorage.setItem("captureRange", captureRange);
		console.log("localStorage", localStorage);

		window.location =
			"index.php?route=consultation&initialDate=" +
			initialDate +
			"&finalDate=" +
			finalDate;
	}
);

/*=============================================
CANCEL DATES RANGE
=============================================*/
$("#daterange-btn-consult").on("cancel.daterangepicker", function (ev, picker) {
	$(this).val("");
	localStorage.removeItem("captureRange");
	localStorage.clear();
	window.location = "consultation";
});

/*=============================================
CAPTURE TODAY'S BUTTON
=============================================*/
$("#daterange-btn-consult").on("click", function () {
	$(".daterangepicker.opensleft .ranges li").on("click", function () {
		//console.log("in");
		var todayButton = $(this).attr("data-range-key");

		if (todayButton == "Today") {
			var d = new Date();

			var day = d.getDate();
			var month = d.getMonth() + 1;
			var year = d.getFullYear();

			if (month < 10) {
				var initialDate = year + "-0" + month + "-" + day;
				var finalDate = year + "-0" + month + "-" + day;
			} else if (day < 10) {
				var initialDate = year + "-" + month + "-0" + day;
				var finalDate = year + "-" + month + "-0" + day;
			} else if (month < 10 && day < 10) {
				var initialDate = year + "-0" + month + "-0" + day;
				var finalDate = year + "-0" + month + "-0" + day;
			} else {
				var initialDate = year + "-" + month + "-" + day;
				var finalDate = year + "-" + month + "-" + day;
			}

			localStorage.setItem("captureRange", "Today");

			window.location =
				"index.php?route=consultation&initialDate=" +
				initialDate +
				"&finalDate=" +
				finalDate;
		}
	});
});

/*=============================================
OPEN XML FILE IN A NEW TAB
=============================================*/

$(".openXML").click(function () {
	var file = $(this).attr("file");
	window.open(file, "_blank");
});

/*=============================================
select appointment date
=============================================*/

$(function () {
	$("#datepicker-1").datepicker({ dateFormat: "yy-mm-dd" });
});

/*=============================================
UPLOAD CONSULTATION IMAGE
=============================================*/

$('#newConsultPhoto0').change(function () {

	var newImage = this.files[0];

	/*===============================================
	  =            validating image format            =
	  ===============================================*/

	if (newImage["type"] != "image/jpeg" && newImage["type"] != "image/png") {
		$('#newConsultPhoto0').val("");

		swal({
			type: "error",
			title: "Error uploading image",
			text: "Image has to be JPEG or PNG!",
			showConfirmButton: true,
			confirmButtonText: "Close",
		});
	} else if (newImage["size"] > 2000000) {
		$('#newConsultPhoto0').val("");

		swal({
			type: "error",
			title: "Error uploading image",
			text: "Image too big. It has to be less than 2Mb!",
			showConfirmButton: true,
			confirmButtonText: "Close",
		});
	} else {
		var imgData = new FileReader();
		imgData.readAsDataURL(newImage);

		$(imgData).on("load", function (event) {
			var routeImg = event.target.result;
			
			var preview = '#preview0';
			
			console.log(preview);
			$(preview).attr("src", routeImg);

	
		});
	}



	/*=====  End of validating image format  ======*/
});

$('#newConsultPhoto1').change(function () {

	var newImage = this.files[0];

	/*===============================================
	  =            validating image format            =
	  ===============================================*/

	if (newImage["type"] != "image/jpeg" && newImage["type"] != "image/png") {
		$('#newConsultPhoto1').val("");

		swal({
			type: "error",
			title: "Error uploading image",
			text: "Image has to be JPEG or PNG!",
			showConfirmButton: true,
			confirmButtonText: "Close",
		});
	} else if (newImage["size"] > 2000000) {
		$('#newConsultPhoto1').val("");

		swal({
			type: "error",
			title: "Error uploading image",
			text: "Image too big. It has to be less than 2Mb!",
			showConfirmButton: true,
			confirmButtonText: "Close",
		});
	} else {
		var imgData = new FileReader();
		imgData.readAsDataURL(newImage);

		$(imgData).on("load", function (event) {
			var routeImg = event.target.result;
			
			var preview = '#preview1';
			
			console.log(preview);
			$(preview).attr("src", routeImg);

	
		});
	}



	/*=====  End of validating image format  ======*/
});

$('#newConsultPhoto2').change(function () {

	var newImage = this.files[0];

	/*===============================================
	  =            validating image format            =
	  ===============================================*/

	if (newImage["type"] != "image/jpeg" && newImage["type"] != "image/png") {
		$('#newConsultPhoto2').val("");

		swal({
			type: "error",
			title: "Error uploading image",
			text: "Image has to be JPEG or PNG!",
			showConfirmButton: true,
			confirmButtonText: "Close",
		});
	} else if (newImage["size"] > 2000000) {
		$('#newConsultPhoto2').val("");

		swal({
			type: "error",
			title: "Error uploading image",
			text: "Image too big. It has to be less than 2Mb!",
			showConfirmButton: true,
			confirmButtonText: "Close",
		});
	} else {
		var imgData = new FileReader();
		imgData.readAsDataURL(newImage);

		$(imgData).on("load", function (event) {
			var routeImg = event.target.result;
			
			var preview = '#preview2';
			
			console.log(preview);
			$(preview).attr("src", routeImg);

	
		});
	}



	/*=====  End of validating image format  ======*/
});

$('#newConsultPhoto3').change(function () {

	var newImage = this.files[0];

	/*===============================================
	  =            validating image format            =
	  ===============================================*/

	if (newImage["type"] != "image/jpeg" && newImage["type"] != "image/png") {
		$('#newConsultPhoto3').val("");

		swal({
			type: "error",
			title: "Error uploading image",
			text: "Image has to be JPEG or PNG!",
			showConfirmButton: true,
			confirmButtonText: "Close",
		});
	} else if (newImage["size"] > 2000000) {
		$('#newConsultPhoto3').val("");

		swal({
			type: "error",
			title: "Error uploading image",
			text: "Image too big. It has to be less than 2Mb!",
			showConfirmButton: true,
			confirmButtonText: "Close",
		});
	} else {
		var imgData = new FileReader();
		imgData.readAsDataURL(newImage);

		$(imgData).on("load", function (event) {
			var routeImg = event.target.result;
			
			var preview = '#preview3';
			
			console.log(preview);
			$(preview).attr("src", routeImg);

	
		});
	}



	/*=====  End of validating image format  ======*/
});
