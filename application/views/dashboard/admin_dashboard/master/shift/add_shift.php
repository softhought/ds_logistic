<script src="<?php echo base_url(); ?>assets/js/adm_scripts/vehicletype.js"></script>  

   <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Shift <?php echo $bodycontent['mode']; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary formBlock">
              <div class="box-header with-border">
                <h3 class="box-title">Shift </h3>
                 <a href="<?php echo base_url();?>shift" class="link_tab"><span class="glyphicon glyphicon-list"></span> List</a>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
             
              <?php 
              $attr = array("id"=>"vehicletypeForm","name"=>"vehicletypeForm");
              echo form_open('',$attr); ?>
                <div class="box-body">
                <p style="font-size: 12px;color: #971414;letter-spacing: 1px;text-align: center;font-weight: bold;">(Note:<?php echo IMPINFO;?> )</p>

                  <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <input type="hidden" name="shiftID" id="shiftID" value="<?php echo $bodycontent['shiftID']; ?>" />
                          <input type="hidden" name="mode" id="mode" value="<?php echo $bodycontent['mode']; ?>" />
                          <label for="equipmentid">Shift Code</label>
                          <input type="text" class="form-control forminputs" id="shiftcode" name="shiftcode" placeholder="" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['vehicletypeEditdata']->vehicle_type;}?>" />
                        </div>
                      </div> <!-- end of col-md-12 -->
                      
                  </div>

                  <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="equipmentid">Start Time</label>
                          <input type="text" class="form-control forminputs" id="starttime" name="starttime" placeholder="" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['vehicletypeEditdata']->vehicle_type;}?>" />
                        </div>
                      </div> <!-- end of col-md-6 -->

                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="equipmentid">End Time</label>
                          <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                  </div>
                  <input class="form-control pull-right timepicker" id="eventtime" name="eventtime" type="text" value="">
                  </div>
                        </div>
                      </div> <!-- end of col-md-6 -->
                      
                  </div>


                  <!-- <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                  </div>
                  <input class="form-control pull-right timepickers" id="eventtime" name="eventtime" type="text" value="">
                  </div> -->
                   

                  <p id="error_msg" class="form_error"></p>

                  <div class="btnDiv">
                      <button type="submit" class="btn btn-primary formBtn" id="vehicletypesavebtn"><?php echo $bodycontent['btnText']; ?></button>
                    
					            <span class="btn btn-primary formBtn loaderbtn" id="loaderbtn" style="display:none;"><i class="fa fa-spinner rotating" aria-hidden="true"></i> <?php echo $bodycontent['btnTextLoader']; ?></span>
                  </div>
                  
                </div>
                <!-- /.box-body -->

                <!-- <div class="box-footer">
                  <button type="submit" class="btn btn-primary">Save</button>
                </div> -->
              <?php echo form_close(); ?>

              <div class="response_msg" id="vehicletype_response_msg">
               
              </div>

            
            </div>
            <!-- /.box -->      
      </div>
    </div>

    </section>
    <!-- /.content -->