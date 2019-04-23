<script src="<?php echo base_url(); ?>assets/js/adm_scripts/breakdown.js"></script>  

   <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Breakdown Cause <?php echo $bodycontent['mode']; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary formBlock">
              <div class="box-header with-border">
                <h3 class="box-title">Breakdown Cause </h3>
                 <a href="<?php echo base_url();?>master/breakdowncause" class="link_tab"><span class="glyphicon glyphicon-list"></span> List</a>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
             
              <?php 
              $attr = array("id"=>"breakdownCauseForm","name"=>"breakdownCauseForm");
              echo form_open('',$attr); ?>
                <div class="box-body">

                  <div class="row">
                  <div class="col-md-12">
                          <div class="form-group">
                            <label for="eqpname">Cause</label>
                            <input type="text" class="form-control forminputs " id="breakdowncause" name="breakdowncause" placeholder="" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['breakdowncauseEditdata']->cause;}?>" >

                           
                          </div>
                      </div><!-- end of col-md-12 -->

                      <div class="col-md-12">
                        <div class="form-group">
                          <input type="hidden" name="breakdowncauseID" id="breakdowncauseID" value="<?php echo $bodycontent['breakdowncauseID']; ?>" />
                          <input type="hidden" name="mode" id="mode" value="<?php echo $bodycontent['mode']; ?>" />
                        
                        </div>
                      </div> <!-- end of col-md-12 -->
                   
                     
                     


                      
                     
                  </div>

                  <p id="error_msg" class="form_error"></p>

                  <div class="btnDiv">
                      <button type="submit" class="btn btn-primary formBtn" id="breakdowncausesavebtn"><?php echo $bodycontent['btnText']; ?></button>
                    
					            <span class="btn btn-primary formBtn loaderbtn" id="loaderbtn" style="display:none;"><i class="fa fa-spinner rotating" aria-hidden="true"></i> <?php echo $bodycontent['btnTextLoader']; ?></span>
                  </div>
                  
                </div>
                <!-- /.box-body -->

                <!-- <div class="box-footer">
                  <button type="submit" class="btn btn-primary">Save</button>
                </div> -->
              <?php echo form_close(); ?>

              <div class="response_msg" id="breakcause_response_msg">
               
              </div>

            
            </div>
            <!-- /.box -->      
      </div>
    </div>

    </section>
    <!-- /.content -->