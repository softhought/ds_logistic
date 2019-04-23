<script src="<?php echo base_url(); ?>assets/js/adm_scripts/breakdown.js"></script>  
<style>
#contralist td{
vertical-align: inherit;
}
</style>
   <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Breakdown List</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

		    <div class="box">
            <div class="box-header">
              <h3 class="box-title">Breakdown List</h3>&nbsp;
            
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
           <div class="col-md-4"></div>
                    

                        <div class="col-md-3" >
                        <div class="form-group">
                            <label></label>
                            <div class="input-group date" data-provide="datepicker" data-date-format="dd/mm/yyyy">
                                <input type="text" class="form-control" name="breakdowndate" id="breakdowndate" value="<?php echo date("d/m/Y"); ?>" readonly >
                                <div class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </div>
                            </div>
                            <!-- /.input group -->
                        </div>
                  </div>   <!-- /.col-md-6 END -->

                </div>

              <div class="datatalberes" id="breakdownlistdata" style="overflow-x:hidden;">
              <table id="example" class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;">
                <thead>
                <tr>
                  <th style="width:5%;">Sl</th>
               
                  <th>Date </th>
                  <th>Vehicle No </th>
                  <th>Driver </th>
                  <th>Mobile </th>
                  <th>Mobile UID </th>
                  <th style="width:10%;">Action</th> 
                
               
                </tr>
                </thead>
                <tbody>
               
              	<?php 
				          
                      $i = 1;
                      foreach ($bodycontent['breakDownList'] as $value) {  

                     if($value->is_approved=="Y")
                    {
                      $status = '<div class="status_brk "><span class="label label-success status_tag breakdownstatus" data-setstatus="N" data-breakdownid="'.$value->breakdown_id.'"> Approved</span></div>';
                    }
                    else
                    {
                      $status = '<div class="status_brk"><span class="label label-danger status_tag breakdownstatus" data-setstatus="Y" 
                      data-breakdownid="'.$value->breakdown_id.'"> Not Approve</span></div>';
                    }
                     
                        
                       
              	?>

					          <tr>
						            <td><?php echo $i; ?></td>
                    <!--    <td>
                          <a href="<?php echo base_url(); ?>project/addProject/<?php echo $value->project_id; ?>" class="btn btn-primary btn-xs" data-title="Edit">
                            <span class="glyphicon glyphicon-pencil"></span>
                          </a>
                        </td> -->
                        <td><?php echo date("d-m-Y",strtotime($value->breakdown_date)); ?></td>                                              
                        <td><?php echo $value->equipment_name; ?></td>                                              
                        <td><?php echo $value->driver_name; ?></td>                                              
                        <td><?php echo $value->mobile_no; ?></td>                                              
                        <td><?php echo $value->mobile_uuid; ?></td>   
                        <td>
                          <a href="<?php echo base_url(); ?>breakdown/addBreakdown/<?php echo $value->breakdown_id; ?>" class="btn btn-success btn-xs" data-title="Edit">
                              <span class=" glyphicon glyphicon-arrow-right "></span>
                            </a>
                        </td>                                           
                                                             
                       
                    </tr>              			
              	<?php
                    $i++;
              		}

              	?>
                </tbody>
               
              </table>

              </div>


            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

    </section>
    <!-- /.content -->