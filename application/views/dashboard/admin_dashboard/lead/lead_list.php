<script src="<?php echo base_url(); ?>assets/js/adm_scripts/lead.js"></script>  
<style>
#contralist td{
vertical-align: inherit;
}
.datepicker{
  z-index: 99999!important;
}
</style>
   <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Lead Against Vehicle List</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

		    <div class="box">
            <div class="box-header">
              <h3 class="box-title">Lead Against Vehicle List</h3>&nbsp;
              <a href="<?php echo base_url();?>lead/addLead" class="link_tab"><span class="glyphicon glyphicon-plus"></span> ADD</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                     <div class="row" style="margin-top:10px;">
                    
                    <div class="col-md-offset-4 col-md-3">
                    <div class="form-group">
                            <label for="project">Project</label> 
                            <select id="project" name="project" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
                              <option value="0">Select</option> 
                                <?php 
                                  if($bodycontent['projectList'])
                                  {
                                    foreach($bodycontent['projectList'] as $project)
                                    { ?>
                                        <option value="<?php echo $project->project_id; ?>" ><strong style="font-weight:700;">(<?php echo $project->project_nickname; ?>)</strong> </option>
                                  <?php   }
                                  }
                                ?>
                            </select>
                          </div>
                    </div> <!-- /.col-md-4 END -->

 
                    </div> <!-- row end-->
              <div class="row">
           <div class="col-md-4">
             
           </div>
                    

                        <div class="col-md-3" >
                        <div class="form-group">
                            <label></label>
                            <div class="input-group date" data-provide="datepicker" data-date-format="dd/mm/yyyy">
                                <input type="text" class="form-control" name="listshiftdate" id="listshiftdate" value="<?php echo date("d/m/Y"); ?>" readonly >
                                <div class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </div>


                            </div>
                              <input type="hidden" name="currentdate" id="currentdate" value="<?php echo date("d/m/Y"); ?>" readonly >
                            <!-- /.input group -->
                        </div>
                  </div>   <!-- /.col-md-6 END -->

                </div>

              <div class="datatalberes" id="leadlistdata" style="overflow-x:hidden;">
              <table id="example" class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;">
                <thead>
                <tr>
                  <th style="width:5%;">Sl</th>
              
                  <th> Project</th>
                  <th>Date </th>
                  <th>Shift Code </th>
                  <th>Excavator </th>
                  <th>Carrying</th>
                  <th>Lead</th>
                  <th>RL In Face</th> 
                  <th>RL In Dump</th> 
                  <th style="width:10%;">Action</th> 
                </tr>
                </thead>
                <tbody>
               
              	<?php 
				          
                      $i = 1;
                      foreach ($bodycontent['leadagvehiList'] as $value) {  
                     
                        
                       
              	?>

					          <tr>
						            <td><?php echo $i; ?></td>
             
                        <td><?php echo $value->project_nickname; ?></td>  
                        <td><?php echo date("d-m-Y", strtotime($value->shift_date)); ?></td>                                              
                        <td><?php echo $value->shift_code; ?></td>                                              
                        <td><?php echo $value->equipment_name; ?></td>                                              
                        <td><?php echo $value->material; ?></td>                                              
                        <td><?php echo $value->lead; ?></td> 
                        <td><?php echo $value->rl_in_face; ?></td>                                             
                        <td><?php echo $value->rl_in_dump; ?></td> 
                        <td>
                           <button type="button" class="btn btn-sm btn-danger editLeadAgnVehicle" 
                           data-toggle="modal" 
                           data-target="#LeadModal" 
                           data-leadagveid="<?php echo $value->id;?>"
                           data-mode ="EDITLEAD" 
                           data-project="<?php echo $value->project_nickname; ?>"
                           data-shiftdate="<?php echo date("d-m-Y", strtotime($value->shift_date)); ?>"
                           data-shiftcode="<?php echo $value->shift_code; ?>"
                           data-excavator="<?php echo $value->equipment_name; ?>"
                           data-carrying="<?php echo $value->material; ?>"
                           data-lead="<?php echo $value->lead; ?>"
                           data-rlinface="<?php echo $value->rl_in_face; ?>"
                           data-rlindump="<?php echo $value->rl_in_dump; ?>"
               ><i class="glyphicon glyphicon-edit"></i></button> 
                        </td>                                             
                         
                    </tr>              			
              	<?php
                    $i++;
              		}

              	?>
                </tbody>
               
              </table>

              </div>


            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

    </section>
    <!-- /.content -->



    <!-- Modal -->
<div class="modal fade" id="LeadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <span class="label label-primary">Edit Lead Against Vehicle</span>
       
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

              <table class="table table-striped table-bordered">
   
    <tbody>
      <tr><td>Project</td><td id="project"></td> </tr>
      <tr><td>Date</td><td id="shiftdate"></td> </tr>
      <tr><td>ShiftCode</td><td id="shiftcode"></td> </tr>
      <tr><td>Excavator</td><td id="excavator"></td> </tr>
      <tr><td>Carrying</td><td id="carrying"></td> </tr>
          <?php
              $attr = array("id"=>"updateLeadForm","name"=>"updateLeadForm");
              echo form_open('',$attr); ?>
              <tr><td>Lead</td><td><input type="text"  class="form-control custom_frm_input"  name="lead" id="lead"  placeholder="Enter Lead"  /> 
                <input type="hidden" id="leadagveid" class="form-control custom_frm_input"  name="leadagveid"  /> 
               

              </td> 
            </tr>
              <tr><td>RL In Face</td><td><input type="text" id="rl_in_face" class="form-control custom_frm_input"  name="rl_in_face"   placeholder="Enter RL in Face"  /> 
              </td> 
            </tr>

             </tr>
              <tr><td>RL In Dump</td><td><input type="text" id="rl_in_dump" class="form-control custom_frm_input"  name="rl_in_dump"   placeholder="Enter RL in Dump"  /> 
              </td> 
            </tr>
              
       
    </tbody>
  </table>
      <p id="error_msg" class="form_error"></p>
      </div>
      <div class="modal-footer">
         <p id="error_msg" class="leadupd_response_msg"></p>
         <div class="btnDiv">
                      <button type="submit" class="btn btn-primary formBtn" id="leadupdsavebtn">Save changes</button>
                    
                      <span class="btn btn-primary formBtn loaderbtn" id="loaderbtn" style="display:none;"><i class="fa fa-spinner rotating" aria-hidden="true"></i> Save changes</span>
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>
                   <?php echo form_close(); ?>
      <!--   <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>