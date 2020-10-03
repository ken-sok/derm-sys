<div class="content-wrapper">

  <section class="content-header">

    <h1>

      Add new Consultation

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

          <!--need multipart/form-data for file upload-->
          <form role="form" method="post" class="consultationForm" enctype="multipart/form-data">

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
                      
                      <span class="input-group-addon"><button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#addDiagnosis" data-dismiss="modal">Add Diagnosis</button></span>

                      </div>

                    </div>

                    <!--=====================================
                    =            DATE INPUT           =
                    ======================================-->

                    <div class="form-group">

                      <div class="input-group">
                        
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                       
                        <input type="text" class="form-control" name="newAppDate" id="datepicker-1" placeholder="Select next appointment date"​ autocomplete = off required>

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
                    
                    <button type="button" class="btn btn-default hidden-lg btnAddProductConsult">Add Product</button>
                    <hr>  


                    <!--=====================================
                    =            ADD IMAGE BUTTON          =
                    ======================================-->
                    <!-- input image -->
                    <div class="form-group">
                      <div class="input-group"> 

                      <div class="panel">Upload image</div>
                      <p class="help-block">Maximum size 2Mb</p>
                    
                      
                      <div class="row" style="padding-left: 30%; padding-bottom: 10%;">
                      
                        <div class="col-xs-5" >

                          <img src="views/img/products/default/anonymous.png" class="img-thumbnail preview" id = "preview0" alt="" width="100px">
                          <input type="file" name="newConsultPhoto[]" id = "newConsultPhoto0" style="display:none;"> 
                          <label for="newConsultPhoto0">Select file</label>
                        </div>
                        
                        <div class="col-xs-5">
                          <img src="views/img/products/default/anonymous.png" class="img-thumbnail preview" id = "preview1" alt="" width="100px">
                          <input type="file" name="newConsultPhoto[]" id = "newConsultPhoto1" style="display:none;"> 
                          <label for="newConsultPhoto1">Select file</label>
                        </div>
                      </div>
                        
                        <div class="row">
                        <div class="col-xs-5">
                          <img src="views/img/products/default/anonymous.png" class="img-thumbnail preview"  id = "preview2" alt="" width="100px">
                          <input type="file" name="newConsultPhoto[]" id = "newConsultPhoto2" style="display:none;"> 
                          <label for="newConsultPhoto2">Select file</label>
                        </div>
                        
                        <div class="col-xs-5">
                          <img src="views/img/products/default/anonymous.png" class="img-thumbnail preview" id = "preview3" alt="" width="100px">
                          <input type="file" name="newConsultPhoto[]" id = "newConsultPhoto3" style="display:none;"> 
                          <label for="newConsultPhoto3">Select file</label>
                        </div>

                      </div>


                      </div>

                    </div> 

                    <hr>

                    <!-- product comment -->

                    <div class="form-group"> 

                          <div class="input-group"> 
                            
                           <label for="comment">Comment:</label>
                           <textarea class="form-control" name="comment" id="comment" rows="4" cols="100"></textarea>

                          </div> 

                    </div> 



                    <div class="row" >

                      <!--=====================================
                        TOTAL INPUT
                      ======================================-->

                      <div class="col-xs-8 pull-right">

                        <table class="table">
                          
                          <thead style = " visibility:hidden;">
                            
                            <th>Total</th>

                          </thead>


                          <tbody>
                            
                            <tr>
                              
                              <td style="width: 50%; visibility:hidden;">

                                <div class="input-group">
                                  
                                  <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                                  
                                  <input type="hidden" step="0.01" class="form-control" name="newSaleTotal" id="newSaleTotal" placeholder="00000" totalSale="" required>

                                  <input type="hidden" name="saleTotal" id="saleTotal" required>

                                </div>

                              </td>

                            </tr>

                          </tbody>

                        </table>
                        
                      </div>

                      <input type="hidden" name="process" id="process" value="consult">

                      <hr>
                      
                    </div>

                    
                </div>

            </div>

            <div class="box-footer">
              <button type="submit" class="btn btn-primary pull-right">Save consultation</button>
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

<!--=====================================
=            module add Diagnosis            =
======================================-->

<!-- Modal -->
<div id="addDiagnosis" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="POST">

        <!--=====================================
        HEADER
        ======================================-->

        <div class="modal-header" style="background: #3c8dbc; color: #fff">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Add Diagnosis</h4>

        </div>

        <!--=====================================
        BODY
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- input Diagnosis -->
            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>

                <input class="form-control input-lg" type="text" id="newDiagnosis" name="newDiagnosis" placeholder="Add Diagnosis" required>

              </div>

            </div>

           
          </div>

        </div>

        <!--=====================================
        FOOTER
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

          <button type="submit" class="btn btn-primary">Save Diagnosis</button>

        </div>

      </form>

      <?php

          $createDiagnosis = new ControllerDiagnosis();
          $createDiagnosis -> ctrCreateDiagnosis();

        ?> 
    </div>

  </div>

</div>

