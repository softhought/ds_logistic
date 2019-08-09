<script src="<?php echo base_url(); ?>assets/js/adm_scripts/driver.js"></script>  
<!--<link rel="stylesheet" href="<?php echo base_url();?>application/assets/diagnostic_theme/bower_components/bootstrap/dist/css/bootstrap.min.css"> -->
   <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Driver <?php echo $bodycontent['mode']; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary formBlock">
              <div class="box-header with-border">
                <h3 class="box-title">Driver </h3>
                 <a href="<?php echo base_url();?>driver" class="link_tab"><span class="glyphicon glyphicon-list"></span> List</a>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
             
              <?php 
              $attr = array("id"=>"driverForm","name"=>"driverForm");
              echo form_open('',$attr); ?>
                <div class="box-body">
                  <p style="font-size: 12px;color: #971414;letter-spacing: 1px;text-align: center;font-weight: bold;">(Note:<?php echo IMPINFO;?> )</p>
                  <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <input type="hidden" name="driverID" id="driverID" value="<?php echo $bodycontent['driverID']; ?>" />
                          <input type="hidden" name="mode" id="mode" value="<?php echo $bodycontent['mode']; ?>" />
                          <label for="cbnatname">Code</label>
                          <input type="text" class="form-control forminputs" id="drivercode" name="drivercode" placeholder="" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['driverEditdata']->driver_code;}?>" />

                          <input type="hidden" class="form-control forminputs" id="prvdrivercode" name="prvdrivercode" placeholder="" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['driverEditdata']->driver_code;}?>" >

                        </div>
                      </div> <!-- end of col-md-6 -->
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="cbnatname">Name</label>
                            <input type="text" class="form-control forminputs " id="drivername" name="drivername" placeholder="" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['driverEditdata']->driver_name;}?>" >
                          </div>
                      </div><!-- end of col-md-6 -->

                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="workingproject">Working Project</label>
                            <!-- <input type="text" class="form-control forminputs " id="workingproject" name="workingproject" placeholder="" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['driverEditdata']->working_project_id;}?>"  > -->
                            <select id="workingproject" name="workingproject" class="form-control"  >
                            <option value="0">Select</option>
                            
                            <?php 
                                if($bodycontent['projectList'])
                                {
                                  foreach($bodycontent['projectList'] as $projectlist)
                                  { ?>
                                      <option value="<?php echo $projectlist->project_nickname; ?>" <?php if(($bodycontent['mode']=="EDIT") && $bodycontent['driverEditdata']->working_project_id==$projectlist->project_nickname){echo "selected";}else{echo "";} ?> ><?php echo $projectlist->project_nickname; ?></option>
                                <?php   }
                                }
                              ?>
                          </select>
                         
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
                                      <option value="<?php echo $vehicleType->vehicle_type_id; ?>" <?php if(($bodycontent['mode']=="EDIT") && $bodycontent['driverEditdata']->vehicle_type_id==$vehicleType->vehicle_type_id){echo "selected";}else{echo "";} ?> ><?php echo $vehicleType->vehicle_type; ?></option>
                                <?php   }
                                }
                              ?>
                          </select>
                        </div>
                      </div><!-- end of col-md-6 -->
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="driverpassword">Pin</label>

                            <input type="text" class="form-control forminputs" id="driverpassword" name="driverpassword" placeholder="" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['driverEditdata']->driver_password;}?>" maxlength="4">
                            

                            <input type="hidden" class="form-control forminputs" id="prvpassword" name="prvpassword" placeholder="" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['driverEditdata']->driver_password;}?>" maxlength="4">
                            
                            <p style="font-size: 12px;color: #9c9c9c;letter-spacing: 1px;">(Note:You can use alphanumeric pin )</p>

                        </div>
                      </div><!-- end of col-md-6 -->

                      <div class="col-md-6">
                     
                        <div class="form-group" id="loader_search" style="display:none;">
                            <label for="driverpassword">&nbsp;</label>
                            <i class="fa fa-circle-o-notch fa-spin" style="margin-top:36px;"></i>
                        </div>
                        

                        <div class="form-group" id="already_used" style="font-size: 14px;color: #E70E2D;font-weight: 600;text-align: center;display:none;">
                            <label for="driverpassword">&nbsp;</label>
                            <i class="fa fa-close" style="margin-top:36px;"></i> Already in use. Please try with new one
                        </div>

                     

                        <div class="form-group" id="available" style="font-size: 14px;color: #0D9644;font-weight: 600;display:none;">
                            <label for="driverpassword">&nbsp;</label>
                            <i class="fa fa-check" style="margin-top:36px;"></i> 
                        </div>

                      </div>
                     
                  </div>

                  <p id="error_msg" class="form_error"></p>

                  <div class="btnDiv">
                      <button type="submit" class="btn btn-primary formBtn" id="driversavebtn"><?php echo $bodycontent['btnText']; ?></button>
                    
					            <span class="btn btn-primary formBtn loaderbtn" id="loaderbtn" style="display:none;"><i class="fa fa-spinner rotating" aria-hidden="true"></i> <?php echo $bodycontent['btnTextLoader']; ?></span>
                  </div>
                  
                </div>
                <!-- /.box-body -->

                <!-- <div class="box-footer">
                  <button type="submit" class="btn btn-primary">Save</button>
                </div> -->
              <?php echo form_close(); ?>

              <div class="response_msg" id="driver_response_msg">
               
              </div>

            
            </div>
            <!-- /.box -->      
      </div>
    </div>

    </section>
    <!-- /.content -->