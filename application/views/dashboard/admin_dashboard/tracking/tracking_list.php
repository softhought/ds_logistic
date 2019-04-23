<script type="text/javascript" src="<?php echo base_url();?>assets/js/adm_scripts/tracking.js"></script>
<style>

.excavatorerror{
 // border: 1px solid #dd4b39!important;
 background: #ef9797!important;
}
</style>
   <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Tracking List</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

		    <div class="box">
            <div class="box-header">
              <h3 class="box-title">Tracking List</h3>&nbsp;
              <!-- <a href="<?php echo base_url();?>contra/contra" class="link_tab"><span class="glyphicon glyphicon-plus"></span> ADD</a> -->
            </div>
            <!-- /.box-header -->

            <form action="#" name="trackingSearchForm" id="trackingSearchForm">
              <div class="row" style="margin: 2% auto;margin-bottom: 0;">
                  <div class="col-md-offset-4 col-md-2">
                        <div class="form-group">
                            <label>From Date</label>
                            <div class="input-group date" data-provide="datepicker" data-date-format="dd/mm/yyyy">
                                <input type="text" class="form-control" name="fromDate" id="fromDate" value="<?php echo date("d/m/Y"); ?>" readonly >
                                <div class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </div>
                            </div>
                            <!-- /.input group -->
                        </div>
                  </div>   <!-- /.col-md-4 END -->
                 
                  <div class="col-md-2">
                        <div class="form-group">
                          <label>To Date</label>
                          <div class="input-group date" data-provide="datepicker" data-date-format="dd/mm/yyyy">
                                <input type="text" class="form-control" name="toDate" id="toDate" value="<?php echo date("d/m/Y"); ?>" readonly >
                                <div class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </div>
                            </div>
                          <!-- /.input group -->
                        </div>
                  </div> <!-- /.col-md-4 END -->
           
                 
               
                
              </div>


              <div class="row" style="margin-bottom: 0;">
                    
                    <div class="col-md-offset-4 col-md-4">
                    <div class="form-group">
                            <label for="project">Project</label> 
                            <select id="project" name="project" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
                              <option value="0">Select</option>
                                <?php 
                                  if($bodycontent['projectList'])
                                  {
                                    foreach($bodycontent['projectList'] as $project)
                                    { ?>
                                        <option value="<?php echo $project->project_id; ?>" ><strong style="font-weight:700;">(<?php echo $project->project_nickname; ?>)</strong> <?php echo $project->project_name; ?></option>
                                  <?php   }
                                  }
                                ?>
                            </select>
                          </div>
                    </div> <!-- /.col-md-4 END -->

 
                    </div> <!-- row end-->


                    <div class="row" style="margin-left: 0;">

                    <div class=" col-md-offset-5 col-md-4">
                    <div class="form-group">
                        <button type="button" id="trackingSearchBtn" class="btn bg-navy btn-flat margin" style="margin-left:10px;margin-top:5px;border-radius: 96px !important;background:#09749f !important;"> <i class="fa fa-search"></i> Search </button>
                    </div>
                  
                  </div> <!-- /.col-md-4 END -->


                    </div> <!-- row end-->

            </form>

      


            <div class="box-body">

              <div id="loader" style="text-align:center;display:none;">
                  <img src="<?php echo base_url(); ?>assets/images/verify_logo.gif"  style="margin-left: auto;margin-right: auto;display: block;" /><br>
                  Please Wait Loading ...
              </div>

              <div id="trackingListView">

                

              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

    </section>
    <!-- /.content -->

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/buttons.print.min.js"></script>


<style>
#trackingSearchForm{
  background: #f2f2f2;
  padding: 1px;
  border-bottom: 5px solid #969292;
}
</style>

<script>

$(document).ready(function() {
    $('#trackinglist').DataTable({
        "dom": 'Bfrtip',
        "buttons": [
            'csv', 'excel', 'pdf', 'print'
        ]
    });
} );




</script>