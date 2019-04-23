<script src="<?php echo base_url(); ?>assets/js/adm_scripts/vehicle.js"></script>  

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
        <li class="active">Vehicle List</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

		    <div class="box">
            <div class="box-header">
              <h3 class="box-title">Vehicle List</h3>&nbsp;
              <a href="<?php echo base_url();?>vehicle/addVehicle" class="link_tab"><span class="glyphicon glyphicon-plus"></span> ADD</a> 
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="datatalberes" style="overflow-x:hidden;">
              <table id="example" class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;">
                <thead>
                <tr>
                  <th style="width:5%;">Sl</th>
                  <th style="width:10%;">Action</th>
                  <th>Equipment Id</th>
                  <th>Project</th>
                  <th>Equipment Name</th>
                  <th>Equipment Model</th>
                  <th>Vehicle Type</th>     
                  <th>Capacity</th>     
                  <th>Mobile</th>             
                  <th>Status</th>             
                </tr>
                </thead>
                <tbody>
               
              	<?php 
				          
                      $i = 1;
                    //   pre($bodycontent['driverList']);
              		foreach ($bodycontent['vehicleList'] as $value) { 
                    
                    $status = "";
                    if($value->vehicle_active_status=="Y")
                    {
                      $status = '<div class="status_dv "><span class="label label-success status_tag vehiclestatus" data-setstatus="N" data-vehicleid="'.$value->vehicle_id.'"><span class="glyphicon glyphicon-ok"></span> Active</span></div>';
                    }
                    else
                    {
                      $status = '<div class="status_dv"><span class="label label-danger status_tag vehiclestatus" data-setstatus="Y" 
                      data-vehicleid="'.$value->vehicle_id.'"><span class="glyphicon glyphicon-remove"></span> Inactive</span></div>';
                    }


              		?>

					<tr>
						            <td><?php echo $i; ?></td>
                        <td>
                          <a href="<?php echo base_url(); ?>vehicle/addVehicle/<?php echo $value->vehicle_id; ?>" class="btn btn-primary btn-xs" data-title="Edit">
                            <span class="glyphicon glyphicon-pencil"></span>
                          </a>
                        </td>
                        <td><?php echo $value->equipment_id; ?></td>
                        <td><?php echo $value->project_nickname; ?></td>                                              
                        <td><?php echo $value->equipment_name; ?></td>
                        <td><?php echo $value->equipment_model; ?></td>
                        <td><?php echo $value->vehicle_type; ?></td>    
                        <td><?php echo $value->capacity; ?></td>    
                        <td><?php echo $value->mobile_uuid; ?><br><b><?php echo $value->mobile_no; ?></b></td>  
                        <td><?php echo $status; ?></td>                                          
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