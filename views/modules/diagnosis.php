<div class="content-wrapper">

  <section class="content-header">

    <h1>

      Diagnosis management

    </h1>

    <ol class="breadcrumb">

      <li><a href="create-consultation"><i class="fa fa-dashboard"></i> Home</a></li>

      <li class="active">Add new consultation</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">

        <button class="btn btn-primary" data-toggle="modal" data-target="#addDiagnosis">Add Diagnosis</button>

      </div>

      <div class="box-body">

        <table class="table table-bordered table-striped dt-responsive DiagnosisTables" width="100%">
       
          <thead>
           
           <tr>
             
             <th style="width:10px">#</th>
             <th>Description</th>
             <th>Actions</th>
           </tr> 

          </thead>

          <tbody>

          <?php

            $item = null;
            $value = null;

            $Diagnosis = ControllerDiagnosis::ctrShowDiagnosis($item, $value);



            foreach ($Diagnosis as $key => $value) {

              echo '<tr>
                          <td>' . ($key + 1) . '</td>
                          <td class="text-uppercase">' . $value['name'] . '</td>
                          <td>

                            <div class="btn-group">
                                
                              <button class="btn btn-warning btnEditDiagnosis" diagnosisId="' . $value["id"] . '" data-toggle="modal" data-target="#modalEditDiagnosis"><i class="fa fa-pencil"></i></button>

                              <button class="btn btn-danger btnDeleteDiagnosis" diagnosisId="' . $value["id"] . '"><i class="fa fa-times"></i></button>

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
=            module add Diagnosis            =
======================================-->

<!-- Modal -->
<div id="addDiagnosis" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="POST" enctype="multipart/form-data">

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

<!--====  End of module add Diagnosis  ====-->

<!--=====================================
EDIT Diagnosis
======================================-->

<div id="modalEditDiagnosis" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        HEADER
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Edit Diagnosis</h4>

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

                <input class="form-control input-lg" type="text" id="editDiagnosis" name="editDiagnosis" required>
                <input type="hidden" name="diagnosisId" id="diagnosisId" required>

              </div>

            </div>

           
          </div>

        </div>

        <!--=====================================
        FOOTER
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

          <button type="submit" class="btn btn-primary">Save changes</button>

        </div>

      </form>

        <?php


          $editDiagnosis = new ControllerDiagnosis();
          $editDiagnosis -> ctrEditDiagnosis();

        ?>      

    </div>

  </div>

</div>

<?php

  $deleteDiagnosis = new ControllerDiagnosis();
  $deleteDiagnosis -> ctrDeleteDiagnosis();

?>
