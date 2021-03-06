<script type="text/javascript" src="<?php echo base_url();?>assets/js/adm_scripts/delayreport.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/tableExport.js"></script>  
<script src="<?php echo base_url(); ?>assets/js/jquery.base64.js"></script>  
<style>

.excavatorerror{
 // border: 1px solid #dd4b39!important;
 background: #ef9797!important;
}

.readonly{
  background-color: #f2e8dc;
}

.projectHeading{
  text-align: center;
  font-weight: bold;
  background-color: #0e8ac5!important;
  color: #FFF !important;
}
</style>
   <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Excavator Delay Report</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

		    <div class="box">
            <div class="box-header">
              <h3 class="box-title">Excavator Delay Report</h3>&nbsp;
             
            </div>
            <!-- /.box-header -->

            <form action="#" name="excavatorDelayReport" id="excavatorDelayReport">



                  <div class="row" style="margin: 2% auto;margin-bottom: 0;">
                    
                    <div class="col-md-offset-4 col-md-2">
                    <div class="form-group">
                            <label for="project">Project</label> 
                            <select id="sel_project" name="sel_project" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
                            
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

                      <div class="col-md-2">
                        <div class="form-group">
                            <label>Shift Date</label>
                            <div class="input-group date" data-provide="datepicker" data-date-format="dd/mm/yyyy">
                                <input type="text" class="form-control" name="shiftdate" id="shiftdate" value="<?php echo date("d/m/Y"); ?>" readonly >
                                <div class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </div>
                            </div>
                            <!-- /.input group -->
                        </div>
                  </div>   <!-- /.col-md-4 END -->

                   
                    </div> <!-- row end-->




          


                        <div class="row" style="margin-left: 0;margin-right: 15px;">
                        <div class=" col-md-offset-4 col-md-4">
                            <p id="error_msg" class="form_error"></p>
                        </div>

                      </div>

                    <div class="row" style="margin-left: 0;">
                    <div class=" col-md-offset-5 col-md-4">
                    <div class="form-group">
                        <button type="button" id="excavatorDelayReportBtn" class="btn bg-navy btn-flat margin" style="margin-left:30px;margin-top:5px;border-radius: 5px !important;background:#09749f !important;"> <i class="fa fa-eye"></i> View </button>
                    </div>
                    <p id="error_msg" class="form_error"></p>
                  </div> <!-- /.col-md-4 END -->


                    </div> <!-- row end-->

            </form>

      


            <div class="box-body">

              <div id="loader" style="text-align:center;display:none;">
                  <img src="<?php echo base_url(); ?>assets/images/verify_logo.gif"  style="margin-left: auto;margin-right: auto;display: block;" /><br>
                  Please Wait Loading ...
              </div>

              <div id="excavatordelayreportView">

                

              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

    </section>
    <!-- /.content -->




<style>
#trackingSearchForm{
  background: #f2f2f2;
  padding: 1px;
  border-bottom: 5px solid #969292;
}
</style>

