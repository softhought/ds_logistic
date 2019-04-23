<script src="<?php echo base_url(); ?>assets/js/adm_scripts/breakdown.js"></script>  
  <link rel="stylesheet" href="<?php echo(base_url());?>assets/css/adm_dashboard.css">

   <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Breakdown <?php echo $bodycontent['mode']; ?></li>
      </ol>
    </section>
    <style type="text/css">
      .datepicker{
        z-index: 99999999 !important;
      }
    </style>

    <!-- Main content -->
    <section class="content">

    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary formBlock">
              <div class="box-header with-border">
                <h3 class="box-title">Breakdown </h3>
                 <a href="<?php echo base_url();?>breakdown" class="link_tab"><span class="glyphicon glyphicon-list"></span> List</a>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
             
              <?php 
              $attr = array("id"=>"BreakdownForm","name"=>"BreakdownForm");
              echo form_open('',$attr); ?>
                <div class="box-body">

                <input type="hidden" name="breakdownID" id="breakdownID" value="<?php echo $bodycontent['breakdownID']; ?>" />
                  <input type="hidden" name="mode" id="mode" value="<?php echo $bodycontent['mode']; ?>" />

                 

                  <div class="row">

                    

                        <div class="col-md-6">
                        <div class="form-group">
                            <label>Breakdown Date</label>
                            <div class="input-group date" >
                                <input type="text" class="form-control" name="shiftdate" id="shiftdate" value="<?php echo date("d-m-Y",strtotime($bodycontent['breakdownEditdata']->breakdown_date)); ?>" readonly >
                                <div class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </div>
                            </div>
                            <!-- /.input group -->
                        </div>
                  </div>   <!-- /.col-md-6 END -->

                         <div class="col-md-6">
                          <div class="form-group">
                            <label for="lead">Vehicle</label>
                            <input type="text" class="form-control forminputs " id="vehicle" name="vehicle" placeholder="Vehicle" autocomplete="off" value="<?php echo $bodycontent['breakdownEditdata']->equipment_name?>" readonly >

                          
                          </div>
                      </div><!-- end of col-md-12 -->

                  </div>

                  <div class="row">

                     <div class="col-md-6">
                          <div class="input-group">
                            <label for="lead">Start Time</label>
                            <input type="text" class="form-control forminputs" id="start_time" name="start_time" placeholder="Start Time" autocomplete="off" value="<?php echo date("h:i A",strtotime($bodycontent['breakdownEditdata']->breakdown_date)); ?>" readonly >
         
                          
                          </div>
                      </div><!-- end of col-md-12 -->
                        <div class="col-md-6">
                        <div class="form-group">
                            <label>Resolve Date</label>
                            <div class="input-group date" data-provide="datepicker" data-date-format="dd/mm/yyyy">
                                <input type="text" class="form-control" name="resolvedate" id="resolvedate" value="<?php echo date("d/m/Y"); ?>" readonly  >
                                <div class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </div>
                            </div>
                            <!-- /.input group -->
                        </div>
                  </div>   <!-- /.col-md-6 END -->

                   


                  </div>

                  <div class="row">

                          <div class="col-md-6">
                          <div class="form-group input-group">
                            <label for="lead">Resolve Time</label>
                            <input type="text" class="form-control forminputs timepicker" id="end_time" name="end_time" placeholder="End Time" autocomplete="off" value="" >

                          
                          </div>

                          
                      </div><!-- end of col-md-12 -->

                       <div class="col-md-6">
                        <div class="form-group">
                          <label for="vehicleType">Breakdown Cause</label> 
                          <select id="breakdown_cause" name="breakdown_cause" class="form-control selectpicker"  data-show-subtext="true" data-live-search="true">
                            <option value="0">Select</option>
                            
                            <?php 
                                if($bodycontent['breakdowncauseList'])
                                {
                                  foreach($bodycontent['breakdowncauseList'] as $cause)
                                  { ?>
                                      <option value="<?php echo $cause->id; ?>" <?php if(($bodycontent['mode']=="EDIT") && $bodycontent['breakdownEditdata']->breakdown_cause_id==$cause->id){echo "selected";}else{echo "";} ?> ><?php echo $cause->cause; ?></option>
                                <?php   }
                                }
                              ?>
                          </select>
                        </div>
                      </div><!-- end of col-md-6 -->

                      
                </div>

               

                   <div class="row">

                         <div class="col-md-12">
                          <div class="form-group">
                            <label for="lead">Narration</label>
                            <input type="text" class="form-control forminputs " id="narration" name="narration" placeholder="Narration" autocomplete="off" value="" >

                          
                          </div>
                      </div><!-- end of col-md-12 -->
                   
                  </div>



                  <p id="error_msg" class="form_error"></p>

                  <div class="btnDiv">
                      <button type="submit" class="btn btn-primary formBtn" id="leadsavebtn"><?php echo $bodycontent['btnText']; ?></button>
                    
					            <span class="btn btn-primary formBtn loaderbtn" id="loaderbtn" style="display:none;"><i class="fa fa-spinner rotating" aria-hidden="true"></i> <?php echo $bodycontent['btnTextLoader']; ?></span>
                  </div>
                  
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