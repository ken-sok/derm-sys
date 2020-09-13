<div class="content-wrapper">

  <section class="content-header">

    <h1>

      Patient management

    </h1>

    <ol class="breadcrumb">

      <li><a href="create-consultation"><i class="fa fa-dashboard"></i> Home</a></li>

      <li class="active">Add new consultation</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">

        <button class="btn btn-primary" data-toggle="modal" data-target="#addCustomer">

        Add Patient

        </button>

      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped dt-responsive tables" width="100%">
       
          <thead>
           
           <tr>
             
             <th style="width:10px">#</th>
             <th>Name</th>
             <th>I.D Customer</th>
             <th>Phone</th>
             <th>Age</th>
             <th>Sex</th>
             <th>Last Visit</th>
             <th>Next Visit</th>
             <th>Medical History</th>
             <th>Actions</th>

           </tr> 

          </thead>

          <tbody>
          
          <?php

            $item = null;
            $valor = null;

            $Customers = controllerCustomers::ctrShowCustomers($item, $valor);

            foreach ($Customers as $key => $value) {
              

              echo '<tr>

                      <td>'.($key+1).'</td>

                      <td>'.$value["name"].'</td>

                      <td>'.$value["id"].'</td>

                      <td>'.$value["phone"].'</td>

                      <td>'.$value["age"].'</td>

                      <td>'.$value["sex"].'</td>             

                      <td>'.$value["lastVisit"].'</td>

                      <td>'.$value["nextVisit"].'</td>

                      <td>'.$value["medicalHis"].'</td>

                      <td>

                        <div class="btn-group">
                            
                          <button class="btn btn-warning btnEditCustomer" data-toggle="modal" data-target="#modalEditCustomer" idCustomer="'.$value["id"].'"><i class="fa fa-pencil"></i></button>

                          <button class="btn btn-danger btnDeleteCustomer" idCustomer="'.$value["id"].'"><i class="fa fa-times"></i></button>

                        </div>  

                      </td>

                    </tr>';
            
              }

          ?>
            
          </tbody>

        </table>

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
MODAL EDIT CUSTOMER
======================================-->

<div id="modalEditCustomer" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        MODAL HEADER
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Edit Patient</h4>

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
                <input type="text" class="form-control input-lg" name="editCustomer" id="editCustomer" required>
                <input type="hidden" id="idCustomer" name="idCustomer">

              </div>

            </div>

            <!-- PHONE INPUT -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 

                <input type="text" class="form-control input-lg" name="editPhone" id="editPhone" data-mask="000 000 0000" required>

              </div>

            </div>
          

            <!-- Sex INPUT -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-transgender"></i></span> 

                
                <select class="form-control input-lg" name="editSex" id="editSex" required>
                    <option value="M">M</option>
                    <option value="F">F</option>
                    <option value="Other">Other</option>
                  </select>

              </div>

            </div>

            <!-- Age INPUT -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-birthday-cake"></i></span> 

                <input type="text" class="form-control input-lg" name="editAge" id="editAge"  max = "200" required>

              </div>

            </div>


            <!-- MEDICAL HISTORY INPUT -->
            <div class="form-group"> 

              <div class="input-group"> 
                
              <label for="comment">General Medical History:</label>
              <textarea class="form-control" name="editMedicalHis" id="editMedicalHis" rows="4" cols="100"></textarea>

              </div> 

            </div> 
  
          </div>

        </div>

        <!--=====================================
        MODAL FOOTER
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

          <button type="submit" class="btn btn-primary">Save changes</button>

        </div>

      </form>

      <?php

        $EditCustomer = new ControllerCustomers();
        $EditCustomer -> ctrEditCustomer();

      ?>

    

    </div>

  </div>

</div>

<?php

  $deleteCustomer = new ControllerCustomers();
  $deleteCustomer -> ctrDeleteCustomer();

?>