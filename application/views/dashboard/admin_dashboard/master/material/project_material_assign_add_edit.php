<script src="<?php echo base_url(); ?>assets/js/adm_scripts/material.js"></script>  

   <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Material Assign to Project <?php echo $bodycontent['mode']; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary formBlock">
              <div class="box-header with-border">
                <h3 class="box-title">Material Assign </h3>
                 <a href="<?php echo base_url();?>material/materialassign" class="link_tab"><span class="glyphicon glyphicon-list"></span> List</a>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
             
              <?php 
              $attr = array("id"=>"materialAssignForm","name"=>"materialAssignForm");
              echo form_open('',$attr); ?>
                <div class="box-body">

                  <div class="row">

                      <div class="col-md-12">
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


                      <div class="col-md-12">
                      <div id="project_div" class="form-group">
                          <label for="project">Material</label> 
                          <select id="material" name="material" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
                            <option value="0">Select</option>
                              <?php 
                                if($bodycontent['materialList'])
                                {
                                  foreach($bodycontent['materialList'] as $material)
                                  { ?>
                                      <option value="<?php echo $material->material_type_id; ?>" <?php if(($bodycontent['mode']=="EDIT") && $bodycontent['materialAssignEditdata']->material_type_id==$material->material_type_id){echo "selected";}else{echo "";} ?> ><?php echo $material->material; ?></option>
                                <?php   }
                                }
                              ?>
                          </select>
                        </div>
                      </div><!-- end of col-md-6 -->

                  <div class="col-md-12">
                          <div class="form-group">
                            <label for="eqpname">Conversation Factor</label>
                            <input type="text" class="form-control forminputs " id="cf" name="cf" placeholder="Conversation Factor" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['materialAssignEditdata']->conversation_factor;}?>" onKeyUp="numericFilter(this);" >

                           
                          </div>
                   </div><!-- end of col-md-12 -->

                      <div class="col-md-12">
                        <div class="form-group">
                          <input type="hidden" name="materialassignID" id="materialassignID" value="<?php echo $bodycontent['materialassignID']; ?>" />
                          <input type="hidden" name="mode" id="mode" value="<?php echo $bodycontent['mode']; ?>" />
                        
                        </div>
                      </div> <!-- end of col-md-12 -->
                   
                     
                     


                      
                     
                  </div>

                  <p id="error_msg" class="form_error"></p>

                  <div class="btnDiv">
                      <button type="submit" class="btn btn-primary formBtn" id="matassignsavebtn"><?php echo $bodycontent['btnText']; ?></button>
                    
					            <span class="btn btn-primary formBtn loaderbtn" id="loaderbtn" style="display:none;"><i class="fa fa-spinner rotating" aria-hidden="true"></i> <?php echo $bodycontent['btnTextLoader']; ?></span>
                  </div>
                  
                </div>
                <!-- /.box-body -->

                <!-- <div class="box-footer">
                  <button type="submit" class="btn btn-primary">Save</button>
                </div> -->
              <?php echo form_close(); ?>

              <div class="response_msg" id="materialass_response_msg">
               
              </div>

            
            </div>
            <!-- /.box -->      
      </div>
    </div>

    </section>
    <!-- /.content -->