<script src="<?php echo base_url(); ?>assets/js/adm_scripts/project.js"></script>  

   <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Project <?php echo $bodycontent['mode']; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary formBlock">
              <div class="box-header with-border">
                <h3 class="box-title">Project </h3>
                 <a href="<?php echo base_url();?>project" class="link_tab"><span class="glyphicon glyphicon-list"></span> List</a>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
             
              <?php 
              $attr = array("id"=>"projectForm","name"=>"projectForm");
              echo form_open('',$attr); ?>
                <div class="box-body">
                <p style="font-size: 12px;color: #971414;letter-spacing: 1px;text-align: center;font-weight: bold;">(Note:<?php echo IMPINFO;?> )</p>

                  <div class="row">
                  <div class="col-md-12">
                          <div class="form-group">
                            <label for="eqpname">Project Name</label>
                            <input type="text" class="form-control forminputs " id="projectname" name="projectname" placeholder="" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['projectEditdata']->project_name;}?>" >

                            <input type="hidden" class="form-control forminputs " id="prvprojectname" name="prvprojectname" placeholder="" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['projectEditdata']->project_name;}?>" >
                          </div>
                      </div><!-- end of col-md-12 -->

                      <div class="col-md-12">
                        <div class="form-group">
                          <input type="hidden" name="projectID" id="projectID" value="<?php echo $bodycontent['projectID']; ?>" />
                          <input type="hidden" name="mode" id="mode" value="<?php echo $bodycontent['mode']; ?>" />
                          <label for="equipmentid">Project Code <span style="font-size: 12px;color: #9c9c9c;letter-spacing: 1px;">(Note:Non editable )</span></label>
                          <input type="text" class="form-control forminputs" id="projectcode" name="projectcode" placeholder="Project Code" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['projectEditdata']->project_nickname;  }?>" <?php if($bodycontent['mode']=="EDIT"){echo "readonly"; }?>  />

                          <input type="hidden" class="form-control forminputs" id="prvprojectcode" name="prvprojectcode" placeholder="" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['projectEditdata']->project_nickname;}?>" >

                        </div>
                      </div> <!-- end of col-md-12 -->
                   
                     
                     
                      <div class="col-md-12">
                      <div class="form-group">
                          <label for="location">Location</label> 
                          <select id="location" name="location" class="form-control"  >
                            <option value="0">Select</option>
                              <?php 
                                if($bodycontent['locationList'])
                                {
                                  foreach($bodycontent['locationList'] as $location)
                                  { ?>
                                      <option value="<?php echo $location->location_id; ?>" 
                                      <?php if(($bodycontent['mode']=="EDIT") && $bodycontent['projectEditdata']->location_id==$location->location_id){echo "selected";}else{echo "";} ?> >
                                       <?php echo $location->location; ?></option>
                                <?php   }
                                }
                              ?>
                          </select>
                        </div>
                      </div><!-- end of col-md-6 -->

                      
                     
                  </div>

                  <p id="error_msg" class="form_error"></p>

                  <div class="btnDiv">
                      <button type="submit" class="btn btn-primary formBtn" id="projectsavebtn"><?php echo $bodycontent['btnText']; ?></button>
                    
					            <span class="btn btn-primary formBtn loaderbtn" id="loaderbtn" style="display:none;"><i class="fa fa-spinner rotating" aria-hidden="true"></i> <?php echo $bodycontent['btnTextLoader']; ?></span>
                  </div>
                  
                </div>
                <!-- /.box-body -->

                <!-- <div class="box-footer">
                  <button type="submit" class="btn btn-primary">Save</button>
                </div> -->
              <?php echo form_close(); ?>

              <div class="response_msg" id="project_response_msg">
               
              </div>

            
            </div>
            <!-- /.box -->      
      </div>
    </div>

    </section>
    <!-- /.content -->