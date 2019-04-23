<script src="<?php echo base_url(); ?>assets/js/adm_scripts/dumpingyard.js"></script>  

   <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dumping Yard <?php echo $bodycontent['mode']; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary formBlock">
              <div class="box-header with-border">
                <h3 class="box-title">Dumping Yard </h3>
                 <a href="<?php echo base_url();?>dumpingyard" class="link_tab"><span class="glyphicon glyphicon-list"></span> List</a>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
             
              <?php 
              $attr = array("id"=>"yardForm","name"=>"yardForm");
              echo form_open('',$attr); ?>
                <div class="box-body">

                  <div class="row">
                

                      <div class="col-md-12">
                        <div class="form-group">
                          <input type="hidden" name="yardID" id="yardID" value="<?php echo $bodycontent['yardID']; ?>" />
                          <input type="hidden" name="mode" id="mode" value="<?php echo $bodycontent['mode']; ?>" />
                          <label for="yard">Yard Name </label>
                          <input type="text" class="form-control forminputs" id="yardname" name="yardname" placeholder="Yard Name" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['yardEditdata']->dumping_yard_name;  }?>" />

                        

                        </div>
                      </div> <!-- end of col-md-12 -->
                   
                     
                     
                      <div class="col-md-12">
                      <div id="project_div" class="form-group">
                          <label for="project">Project</label> 
                          <select id="project" name="project" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
                            <option value="">Select</option>
                              <?php 
                                if($bodycontent['projectList'])
                                {
                                  foreach($bodycontent['projectList'] as $project)
                                  { ?>
                                      <option value="<?php echo $project->project_id; ?>" <?php if(($bodycontent['mode']=="EDIT") && $bodycontent['yardEditdata']->project_id==$project->project_id){echo "selected";}else{echo "";} ?> ><?php echo $project->project_nickname; ?></option>
                                <?php   }
                                }
                              ?>
                          </select>
                        </div>
                      </div><!-- end of col-md-6 -->

                      
                     
                  </div>

                  <p id="error_msg" class="form_error"></p>

                  <div class="btnDiv">
                      <button type="submit" class="btn btn-primary formBtn" id="yardsavebtn"><?php echo $bodycontent['btnText']; ?></button>
                    
					            <span class="btn btn-primary formBtn loaderbtn" id="loaderbtn" style="display:none;"><i class="fa fa-spinner rotating" aria-hidden="true"></i> <?php echo $bodycontent['btnTextLoader']; ?></span>
                  </div>
                  
                </div>
                <!-- /.box-body -->

                <!-- <div class="box-footer">
                  <button type="submit" class="btn btn-primary">Save</button>
                </div> -->
              <?php echo form_close(); ?>

              <div class="response_msg" id="yard_response_msg">
               
              </div>

            
            </div>
            <!-- /.box -->      
      </div>
    </div>

    </section>
    <!-- /.content -->