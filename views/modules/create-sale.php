<div class="content-wrapper">

  <section class="content-header">

    <h1>

      Add new Receipt

    </h1>

    <ol class="breadcrumb">

      <li><a href="create-consultation"><i class="fa fa-dashboard"></i> Home</a></li>

      <li class="active">Add new Consultation</li>

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

          <form role="form" method="post" class="saleForm">

            <div class="box-body">
                
                <div class="box">


                    <!--=====================================
                    CODE INPUT
                    ======================================-->
                  
                    
                    <div class="form-group">

                      <div class="input-group">
                        
                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                        
                        <?php 
                          $item = null;
                          $value = null;

                          $sales = ControllerSales::ctrShowSales($item, $value);

                          if(!$sales){

                            echo '<input type="text" class="form-control" name="newSale" id="newSale" value="10001" readonly>';
                          }

                          else{
                            $last = True;

                            foreach ($sales as $key => $value) {

                               
                              if ($last) {
                                $code = $value["code"] + 1;
                                $last = False;
                              }
                              
                            }

                            echo '<input type="text" class="form-control" name="newSale" id="newSale" value="'.$code.'" readonly>';

                          }

                        ?>

                      </div>


                    </div>


                    <!--=====================================
                    =            CUSTOMER INPUT           =
                    ======================================-->
                  
                    
                    <div class="form-group">

                      <div class="input-group">
                        
                        <span class="input-group-addon"><i class="fa fa-users"></i></span>
                        <select class="form-control" name="selectCustomer" id="selectCustomer" required>
                          
                            <option value="">Select customer</option>

                            <?php 

                            $item = null;
                            $value = null;

                            $customers = ControllerCustomers::ctrShowCustomers($item, $value);

                            foreach ($customers as $key => $value) {
                              echo '<option value="'.$value["id"].'">'.$value["name"].' '.$value["phone"].'</option>';
                            }


                            ?>

                        </select>

                        <span class="input-group-addon"><button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#addCustomer" data-dismiss="modal">Add Patient</button></span>

                      </div>

                    </div>

                    <!--=====================================
                    =            DIAGNOSIS INPUT           =
                    ======================================-->

                    <div class="form-group">

                      <div class="input-group">
                        
                        <span class="input-group-addon"><i class="fa fa-search"></i></span>
                       
                        <select class="form-control" name="selectDiagnosis" id="selectDiagnosis" required>
                          
                          <option value="">Select diagnosis</option>

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


                    </div>

                    <input type="hidden" name="productsList" id="productsList">

                    <!--=====================================
                    =            ADD PRODUCT BUTTON          =
                    ======================================-->
                    
                    <button type="button" class="btn btn-default hidden-lg btnAddProductSale">Add Product</button>
                    
                   

                    <hr>

                    <!-- product comment -->

                    <div class="form-group"> 

                          <div class="input-group"> 
                            
                           <label for="comment">Comment:</label>
                           <textarea class="form-control" name="comment" id="comment" rows="4" cols="100"></textarea>

                          </div> 

                    </div> 

                    <div class="row">

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
                              
                              <td style="width: 50%">

                                <div class="input-group">
                                  
                                  <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                                  
                                  <input type="number" step="0.01" class="form-control" name="newSaleTotal" id="newSaleTotal" placeholder="00000" totalSale="" readonly required>

                                  <input type="hidden" name="saleTotal" id="saleTotal" required>

                                </div>

                              </td>

                            </tr>

                          </tbody>

                        </table>
                        
                      </div>

                      <input type="hidden" name="process" id="process" value="sale">

                      <hr>
                      
                    </div>

                    
                </div>

            </div>

            <div class="box-footer">
              <button type="submit" class="btn btn-primary pull-right">Save receipt</button>
            </div>
          </form>

          <?php

            $saveSale = new ControllerSales();
            $saveSale -> ctrCreateSale();
            
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
              
              <table class="table table-bordered table-striped dt-responsive salesTable">
                  
                <thead>

                   <tr>
                     
                     <th style="width:10px">#</th>
                     <th>Image</th>
                     <th style="width:30px">Code</th>
                     <th>Description</th>
                     <!--<th>Stock</th>-->
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

<div id="addCustomer" class="modal fade" role="dialog">
  
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
                <input class="form-control input-lg" type="text" placeholder = "Phone" name="newPhone" data-mask="000 000 0000" required>
              </div>
            </div>
          


            <!-- SEX INPUT -->

            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-transgender"></i></span>
                  <select class="form-control input-lg" name="newSex" id="newSex" required>
                    <option value="">Select Sex</option>
                    <option value="M">M</option>
                    <option value="F">F</option>
                    <option value="Other">Other</option>
                  </select>
              </div>
            </div>


             <!-- AGE INPUT -->

            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-birthday-cake"></i></span>
                <input class="form-control input-lg" type="number" name="newAge" placeholder="Age" max = "200" required>
              </div>
            </div>

            <!-- MEDICAL HISTORY INPUT -->
            <div class="form-group"> 

              <div class="input-group"> 
                
              <label for="comment">General Medical History:</label>
              <textarea class="form-control" name="newMedicalHis" id="newMedicalHis" rows="4" cols="100"></textarea>

              </div> 

            </div> 

          </div>

        </div>

        <!--=====================================
        MODAL FOOTER
        ======================================-->

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save Patient</button>
        </div>
      </form>

      <?php

        $createCustomer = new ControllerCustomers();
        $createCustomer -> ctrCreateCustomer();

      ?>
    </div>

  </div>

</div>
