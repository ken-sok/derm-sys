<div class="content-wrapper">

  <section class="content-header">

    <h1>

      Edit Consultation

    </h1>

    <ol class="breadcrumb">

      <li><a href="create-consultation"><i class="fa fa-dashboard"></i> Home</a></li>

      <li class="active">Add Consultation</li>

    </ol>

  </section>

  <section class="content">

    <div class="row">
      
      <!--=============================================
      THE FORM
      =============================================-->
      <div class="col-lg-5 col-xs-12">
        
        <div class="box box-success">

          <div class="box-header with-border"></div>

          <form role="form" method="post" class="consultationForm" enctype="multipart/form-data">

            <div class="box-body">
                
                <div class="box">

                  <?php

                    $item = "id";
                    $value = $_GET["idSale"];

                    $sale = ControllerSales::ctrShowSales($item, $value);

                    $itemCustomers = "id";
                    $valueCustomers = $sale["idCustomer"];

                    $customers = ControllerCustomers::ctrShowCustomers($itemCustomers, $valueCustomers);
                  ?>



                    <!--=====================================
                    CODE INPUT
                    ======================================-->
                  
                    
                    <div class="form-group">

                      <div class="input-group">
                        
                        <span class="input-group-addon"><i class="fa fa-key"></i></span>

                        <input type="text" class="form-control" id="newSale" name="editSale" value="<?php echo $sale["code"]; ?>" readonly>

                      </div>


                    </div>


                    <!--=====================================
                    =            CUSTOMER INPUT           =
                    ======================================-->
                  
                    
                    <div class="form-group">

                      <div class="input-group">
                        
                        <span class="input-group-addon"><i class="fa fa-users"></i></span>

                        <select class="form-control" name="selectCustomer" id="selectCustomer" required>
                          
                            <option value="<?php echo $customers["id"]; ?>"><?php echo $customers["name"];echo ' '; echo $customers["phone"]; ?></option>

                            <?php 

                            $item = null;
                            $value = null;

                            $customers = ControllerCustomers::ctrShowCustomers($item, $value);

                            foreach ($customers as $key => $value) {
                              echo '<option value="'.$value["id"].'">'.$value["name"].' '.$value["phone"].'</option>';
                            }


                            ?>

                            

                        </select>

                      </div>

                    </div>

                    <!--=====================================
                    =            DIAGNOSIS INPUT           =
                    ======================================-->

                    <div class="form-group">

                      <div class="input-group">
                        
                        <span class="input-group-addon"><i class="fa fa-search"></i></span>
                       
                        <select class="form-control" name="editDiagnosis" id="editDiagnosis" required>

                        <?php 

                          $item = 'id';
                          $value = $sale["diagnosis"];

                          $diagnosis = ControllerDiagnosis::ctrShowDiagnosis($item, $value);


                        ?>

                          <option value="<?php echo $sale["diagnosis"]; ?>"><?php echo $diagnosis["name"]; ?></option>

                          <?php 

                            $item = null;
                            $value = null;

                            $diagnosis = ControllerDiagnosis::ctrShowDiagnosis($item, $value);

                            foreach ($diagnosis as $key => $value) {
                              echo '<option value="'.$value["id"].'">'.$value["name"].'</option>';
                            }


                            ?>



                      </select>

                      </div>

                    </div>


                    <!--=====================================
                    =            PRODUCT INPUT           =
                    ======================================-->
                  
                    
                    <div class="form-group row newProduct">
                      <?php

                        $productList = json_decode($sale["products"], true);

                        foreach ($productList as $key => $value) {

                          $item = "id";
                          $valueProduct = $value["id"];
                          $order = "id";

                          $answer = ControllerProducts::ctrShowproducts($item, $valueProduct, $order);

                          $lastStock = $answer["stock"] + $value["quantity"];
                          
                          echo '<div class="row" style="padding:5px 15px">
                    
                                <div class="col-xs-5" style="padding-right:0px">
                    
                                  <div class="input-group">
                        
                                    <span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs removeProduct" idProduct="'.$value["id"].'"><i class="fa fa-times"></i></button></span>

                                    <input type="text" class="form-control newProductDescription" idProduct="'.$value["id"].'" name="addProduct" value="'.$value["description"].'" readonly required>

                                  </div>

                                </div>

                                <div class="col-xs-2">
                      
                                  <input type="number" class="form-control newProductQuantity" name="newProductQuantity" min="1" value="'.$value["quantity"].'" required>

                                </div>

                                
                                <div class="col-xs-5">
                      
                                  <input type="text" class="form-control newProductScale" idProduct="'.$value["id"].'" value="'.$value["scale"].'"​​ scale="'.$value["scale"].'"  required>

                                </div>

                                <div class="col-xs-3 enterPrice" style="display:none;">

                                  <div class="input-group">

                                    <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                           
                                    <input type="text" class="form-control newProductPrice" realPrice="'.$value["price"].'" name="newProductPrice" value="'.$value["totalPrice"].'" readonly required>
           
                                  </div>
                       
                                </div>

                               </div>

                              
 
                                <!-- product usage -->

                                <div class="row" style="padding:5px 15px">

                                <div class="col-xs-8 enterUsage" style="padding-right:0px;">
                    
                                  <div class="input-group">
                    
                                    <span class="input-group-addon"><i class="fa fa-repeat"></i></span>
                                       
                                    <input type="text" class="form-control newProductUsage" idProduct="'.$value["id"].'" name="addProductUsage" usage="'.$value["usage"].'" value = "'.$value["usage"].'" required>
                       
                                  </div>
                                   
                                </div>

                              </div>';


                        

                        }
                        ?>

                    </div>

                    <input type="hidden" name="productsList" id="productsList">

                    <!--=====================================
                    =            ADD PRODUCT BUTTON          =
                    ======================================-->
                    
                    <button type="button" class="btn btn-default hidden-lg btnAddProductConsult">Add Product</button>
                    
                    <hr>

                    <!--=====================================
                    =            ADD IMAGE BUTTON          =
                    ======================================-->
                    <!-- input image -->
                    <?php
                    $ConsultPhotos = json_decode($sale["images"]);
                    ?>

                    
                    <div class="form-group">
                      <div class="input-group"> 

                      <div class="panel">Upload image</div>
                      <p class="help-block">Maximum size 2Mb</p>

                      <div class="row">
                      
                        <div class="col-xs-5" >

                          <img src="<?php echo $ConsultPhotos[0]; ?>" class="img-thumbnail preview" id = "preview0" alt="" width="100px">
                          
                        </div>
                        
                        <div class="col-xs-5">
                          <img src="<?php echo $ConsultPhotos[1]; ?>" class="img-thumbnail preview" id = "preview1" alt="" width="100px">
                          
                        </div>
                      
                        
                        
                        <div class="col-xs-5">
                          <img src="<?php echo $ConsultPhotos[2]; ?>" class="img-thumbnail preview"  id = "preview2" alt="" width="100px">

                        </div>
                        
                        <div class="col-xs-5">
                          <img src="<?php echo $ConsultPhotos[3]; ?>" class="img-thumbnail preview" id = "preview3" alt="" width="100px">

                        </div>
                      </div>   
                      

                      <input type="hidden" name="currentConsultPhoto" id="currentConsultPhoto" value='<?php echo $sale["images"]; ?>'>


                      </div>

                    </div> 

                   
                    <hr>

                     <!-- product comment -->

                    <div class="form-group"> 

                          <div class="input-group"> 
                            
                           <label for="comment">Comment:</label>
                           <textarea class="form-control" name="comment" id="comment" rows="4" value = "<?php echo $sale["comment"]; ?>"cols="100"><?php echo $sale["comment"]; ?></textarea>

                          </div> 

                    </div> 

                    <div class="row" style="visibility:hidden;">

                      <!--=====================================
                        TOTAL INPUT
                      ======================================-->

                      <div class="col-xs-8 pull-right">

                        <table class="table">
                          
                          <thead>
                            
                            
                            <th>Total</th>

                          </thead>


                          <tbody>
                            
                            <tr>
                            
                            <input type="hidden" class="form-control moneyRate" name="moneyRate" id="moneyRate" moneyRate="" value="<?php echo $sale["exchangeRate"] ; ?>" required>
                              <td style="width: 50%">

                                <div class="input-group">
                                  
                                  <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                                  
                                  <input type="number" class="form-control" name="newSaleTotal" id="newSaleTotal" placeholder="00000" totalSale="<?php echo $sale["totalPrice"]; ?>" value="<?php echo $sale["totalPrice"]; ?>" readonly required>

                                  <input type="hidden" name="saleTotal" id="saleTotal" value="<?php echo $sale["totalPrice"]; ?>" required>

                                </div>

                              </td>

                            </tr>

                          </tbody>

                        </table>
                        
                      </div>

                      <input type="hidden" name="process" id="process" value="consult">

                      <hr>
                      
                    </div>

                    <hr>

                    <br>
                    
                </div>

            </div>

            <div class="box-footer">
              <button type="submit" class="btn btn-primary pull-right">Save changes</button>
            </div>
          </form>

          <?php

            $editSale = new ControllerSales();
            $editSale -> ctrEditSale();
            
          ?>

        </div>

      </div>


      <!--=============================================
      =            PRODUCTS TABLE                   =
      =============================================-->


      <div class="col-lg-7 hidden-md hidden-sm hidden-xs">
        
          <div class="box box-warning">
            
            <div class="box-header with-border"></div>

            <div class="box-body">
              
              <table class="table table-bordered table-striped dt-responsive consultationTable">
                  
                <thead>

                   <tr>
                     
                     <th style="width:10px">#</th>
                     <th>Image</th>
                     <th style="width:30px">Code</th>
                     <th>Description</th>
                     <th>Actions</th>

                   </tr> 

                </thead>

              </table>

            </div>

          </div>


      </div>

    </div>

  </section>

</div>


<!--=====================================
MODAL ADD CUSTOMER
======================================-->

<div id="modalAddCustomer" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="POST">

        <!--=====================================
        MODAL HEADER
        ======================================-->

        <div class="modal-header" style="background: #3c8dbc; color: #fff">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Add Patient</h4>

        </div>

        <!--=====================================
        MODAL BODY
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

             <!-- NAME INPUT -->

            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input class="form-control input-lg" type="text" name="newCustomer" placeholder="Write name" required>
              </div>
            </div>


            <!-- PHONE INPUT -->


            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                <input class="form-control input-lg" type="text" placeholder = "Phone" name="newPhone" data-mask="000 000 0000">
              </div>
            </div>
          


            <!-- SEX INPUT -->

            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-transgender"></i></span>
                <input class="form-control input-lg" type="text" name="newSex" placeholder="Sex" required>
              </div>
            </div>


             <!-- AGE INPUT -->

            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input class="form-control input-lg" type="number" name="newAge" placeholder="Age" max = "200" required>
              </div>
            </div>

          </div>

        </div>

        <!--=====================================
        MODAL FOOTER
        ======================================-->

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save Customer</button>
        </div>
      </form>

      <?php

        $createCustomer = new ControllerCustomers();
        $createCustomer -> ctrCreateCustomer();

      ?>
    </div>

  </div>
</div>

<!--====  End of module add Customer  ====-->