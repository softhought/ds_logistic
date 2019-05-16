<script src="<?php echo base_url(); ?>assets/js/adm_scripts/lead.js"></script>  

   <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Lead Against Vehicle <?php echo $bodycontent['mode']; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary formBlockMedium">
              <div class="box-header with-border">
                <h3 class="box-title">Lead Against Vehicle </h3>
                 <a href="<?php echo base_url();?>lead" class="link_tab"><span class="glyphicon glyphicon-list"></span> List</a>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
             
              <?php 
              $attr = array("id"=>"leadForm","name"=>"leadForm");
              echo form_open('',$attr); ?>
                <div class="box-body">

                <input type="hidden" name="leadID" id="leadID" value="<?php echo $bodycontent['leadID']; ?>" />
                  <input type="hidden" name="mode" id="mode" value="<?php echo $bodycontent['mode']; ?>" />

                  <div class="row">
                          <div class="col-md-6">
                      <div id="project_div" class="form-group">
                          <label for="project">Project</label> 
                          <select id="project" name="project" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
                            <option value="0">Select</option>
                              <?php 
                                if($bodycontent['projectList'])
                                {
                                  foreach($bodycontent['projectList'] as $project)
                                  { ?>
                                      <option value="<?php echo $project->project_id; ?>" <?php if(($bodycontent['mode']=="EDIT") && $bodycontent['materialAssignEditdata']->project_id==$project->project_id){echo "selected";}else{echo "";} ?> ><?php echo $project->project_nickname; ?></option>
                                <?php   }
                                }
                              ?>
                          </select>
                        </div>
                      </div><!-- end of col-md-6 -->

                        <div class="col-md-6">
                      <div class="form-group">
                          <label for="sel_servier">Surveyor</label> 
                          <div id="servier_dropdown">
                          <select id="sel_servier" name="sel_servier" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
                            <option value="0">Select</option>
                              <!-- <?php 
                                if($bodycontent['servierList'])
                                {
                                  foreach($bodycontent['servierList'] as $servierlist)
                                  { ?>
                                      <option value="<?php echo $servierlist->supervisor_id; ?>"  >
                                       <?php echo $servierlist->name; ?></option>
                                <?php   }
                                }
                              ?> -->
                          </select>
                        </div>

                        </div>
                      </div><!-- end of col-md-6 -->

                  </div>

                  <div class="row">
                   

                      <div class="col-md-4">
                      <div class="form-group">
                          <label for="shift">Shift</label> 
                          <select id="sel_shift" name="sel_shift" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
                            <option value="0">Select</option>
                            <?php 
                                if($bodycontent['materialTypeList'])
                                {
                                  foreach($bodycontent['shiftList'] as $shiftlist)
                                  { ?>
                                      <option value="<?php echo $shiftlist->shift_code; ?>"  >
                                       <?php echo $shiftlist->shift_code; ?></option>
                                <?php   }
                                }
                              ?>
                            
                          </select>
                        </div>
                      </div><!-- end of col-md-4 -->

                       <div class="col-md-4">
                        <div class="form-group">
                            <label>For Date</label>
                            <div class="input-group date" data-provide="datepicker" data-date-format="dd/mm/yyyy">
                                <input type="text" class="form-control" name="shiftdate" id="shiftdate" value="<?php echo date("d/m/Y"); ?>" readonly >
                                <div class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </div>
                            </div>
                            <!-- /.input group -->
                        </div>
                  </div>   <!-- /.col-md-4 END -->

                   <div class="col-md-4">
                      <div class="form-group">
                          <label for="excavator">Excavator</label> 
                          <div id="excavator_dropdown">
                          <select id="sel_excavator" name="sel_excavator" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
                            <option value="0">Select</option>
                            
                   
                             
                          </select>
                        </div>
                        </div>
                      </div><!-- end of col-md-4 -->

                  </div>

                  <!-- start of details -->
                 <div id="material_details_data">

               

                </div><!-- end of details -->



                

                  



                  <p id="error_msg" class="form_error"></p>

               
                  
                </div>
                <!-- /.box-body -->

                <!-- <div class="box-footer">
                  <button type="submit" class="btn btn-primary">Save</button>
                </div> -->
              <?php echo form_close(); ?>

              <div class="response_msg" id="lead_response_msg">
               
              </div>

            
            </div>
            <!-- /.box -->      
      </div>
    </div>

    </section>
    <!-- /.content -->