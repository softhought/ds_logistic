<script src="<?php echo base_url(); ?>assets/js/adm_scripts/vehicle.js"></script>  

   <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Vehicle <?php echo $bodycontent['mode']; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary formBlock">
              <div class="box-header with-border">
                <h3 class="box-title">Vehicle </h3>
                 <a href="<?php echo base_url();?>vehicle" class="link_tab"><span class="glyphicon glyphicon-list"></span> List</a>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
             
              <?php 
              $attr = array("id"=>"vehicleForm","name"=>"vehicleForm");
              echo form_open('',$attr); ?>
                <div class="box-body">
<p style="font-size: 12px;color: #971414;letter-spacing: 1px;text-align: center;font-weight: bold;">(Note:<?php echo IMPINFO;?> )</p>
                  <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <input type="hidden" name="vehicleID" id="vehicleID" value="<?php echo $bodycontent['vehicleID']; ?>" />
                          <input type="hidden" name="mode" id="mode" value="<?php echo $bodycontent['mode']; ?>" />
                          <label for="equipmentid">Equipment ID <span style="font-size: 12px;color: #9c9c9c;letter-spacing: 1px;">(Note:Non editable )</span></label>
                          <input type="text" class="form-control forminputs" id="equipmentid" name="equipmentid" placeholder="" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['vehicleEditdata']->equipment_id;  }?>" <?php if($bodycontent['mode']=="EDIT"){echo "readonly"; }?>  />

                          <input type="hidden" class="form-control forminputs" id="prvequipmentid" name="prvequipmentid" placeholder="" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['vehicleEditdata']->equipment_id;}?>" >

                        </div>
                      </div> <!-- end of col-md-6 -->
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="eqpname">Equipment Name</label>
                            <input type="text" class="form-control forminputs " id="eqpname" name="eqpname" placeholder="" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['vehicleEditdata']->equipment_name;}?>" >

                            <input type="hidden" class="form-control forminputs " id="prveqpname" name="prveqpname" placeholder="" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['vehicleEditdata']->equipment_name;}?>" >
                          </div>
                      </div><!-- end of col-md-6 -->
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="eqpmodel">Equipment Model</label>
                            <input type="text" class="form-control forminputs " id="eqpmodel" name="eqpmodel" placeholder="" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['vehicleEditdata']->equipment_model;}?>"  >
                          </div>
                      </div><!-- end of col-md-6 -->
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="vehicleType">Type</label> 
                          <select id="vehicleType" name="vehicleType" class="form-control"  >
                            <option value="0">Select</option>
                            
                            <?php 
                                if($bodycontent['vehicleTypeList'])
                                {
                                  foreach($bodycontent['vehicleTypeList'] as $vehicleType)
                                  { ?>
                                      <option value="<?php echo $vehicleType->vehicle_type_id; ?>" <?php if(($bodycontent['mode']=="EDIT") && $bodycontent['vehicleEditdata']->vehicle_type_id==$vehicleType->vehicle_type_id){echo "selected";}else{echo "";} ?> ><?php echo $vehicleType->vehicle_type; ?></option>
                                <?php   }
                                }
                              ?>
                          </select>
                        </div>
                      </div><!-- end of col-md-6 -->

                         <div class="col-md-6">
                          <div class="form-group">
                            <label for="eqpname">Capacity</label>
                            <input type="text" class="form-control forminputs " id="capacity" name="capacity" placeholder="" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['vehicleEditdata']->capacity;}?>" onKeyUp="numericFilter(this);">

                          </div>
                      </div><!-- end of col-md-6 -->

                      <div class="col-md-12">
                      <div class="form-group">
                          <label for="project">Project</label> 
                          <select id="project" name="project" class="form-control"  >
                            <option value="0">Select</option>
                              <?php 
                                if($bodycontent['projectList'])
                                {
                                  foreach($bodycontent['projectList'] as $project)
                                  { ?>
                                      <option value="<?php echo $project->project_id; ?>" <?php if(($bodycontent['mode']=="EDIT") && $bodycontent['vehicleEditdata']->project_id==$project->project_id){echo "selected";}else{echo "";} ?> ><strong style="font-weight:700;">(<?php echo $project->project_nickname; ?>)</strong> <?php echo $project->project_name; ?></option>
                                <?php   }
                                }
                              ?>
                          </select>
                        </div>
                      </div><!-- end of col-md-6 -->

                      
                     
                  </div>

                  <p id="error_msg" class="form_error"></p>

                  <div class="btnDiv">
                      <button type="submit" class="btn btn-primary formBtn" id="vehiclesavebtn"><?php echo $bodycontent['btnText']; ?></button>
                    
					            <span class="btn btn-primary formBtn loaderbtn" id="loaderbtn" style="display:none;"><i class="fa fa-spinner rotating" aria-hidden="true"></i> <?php echo $bodycontent['btnTextLoader']; ?></span>
                  </div>
                  
                </div>
                <!-- /.box-body -->

                <!-- <div class="box-footer">
                  <button type="submit" class="btn btn-primary">Save</button>
                </div> -->
              <?php echo form_close(); ?>

              <div class="response_msg" id="vehicle_response_msg">
               
              </div>

            
            </div>
            <!-- /.box -->      
      </div>
    </div>

    </section>
    <!-- /.content -->