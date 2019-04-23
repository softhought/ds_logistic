<script src="<?php echo base_url(); ?>assets/js/adm_scripts/assignMobiletoVehicle.js"></script>  

<?php //pre($bodycontent['mobileList']); ?>

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
        <li class="active">Assigned List</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

		    <div class="box">
            <div class="box-header">
              <h3 class="box-title">Assigned List</h3>&nbsp;
              <a href="<?php echo base_url();?>master/assignMobiletoVehicle" class="link_tab"><span class="glyphicon glyphicon-plus"></span> ADD</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="datatalberes" style="overflow-x:auto;">
              <table id="example" class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;">
                <thead>
                <tr>
                  <th style="width:10%;">Sl</th>
                  <th>Mobile UID</th>                  
                  <th>Mobile</th>                  
                  <th>Vehicle</th>   
                  <th>Status</th>                 
                  <!-- <th style="text-align:right;width:5%;">Action</th>                   -->
                </tr>
                </thead>
                <tbody>
               
              	<?php 
				          
                      $i = 1;
                    //   pre($bodycontent['ListData']);
              		foreach ($bodycontent['ListData'] as $value) {  
                    
                    $status = "";
                    if($value->is_active=="Y")
                    {
                      $status = '<div class="status_dv "><span class="label label-success status_tag assignstatus" data-setstatus="N" data-vehicleid="'.$value->vehicle_id.'"><span class="glyphicon glyphicon-ok"></span> Active</span></div>';
                    }
                    else
                    {
                      $status = '<div class="status_dv"><span class="label label-danger status_tag assignstatus" data-setstatus="Y" 
                      data-vehicleid="'.$value->vehicle_id.'"><span class="glyphicon glyphicon-remove"></span> Inactive</span></div>';
                    }
              		?>

					<tr>
						<td><?php echo $i; ?></td>
                        <td><?php echo $value->mobile_uuid; ?></td>                                     
                        <td><?php echo $value->mobile_no; ?></td>                                     
                        <td><?php echo $value->equipment_name; ?></td> 
                        <td><?php echo $status; ?></td>                                       
                        <!-- <td align="center"> 
							<a href="<?php echo base_url(); ?>master/assignMobiletoVehicle/<?php echo $value->vehicle_id; ?>" class="btn btn-primary btn-xs" data-title="Edit">
								<span class="glyphicon glyphicon-pencil"></span>
							</a>
							 <a href="javascript:void(0);" id="deleteBtn_<?php echo $i; ?>" data-text="<?php //echo $value->id;?>" class="btn deleteBtn btn-danger btn-xs" data-title="Delete">
								<span class="glyphicon glyphicon-trash"></span> 
							</a>
						
						</td>                                     -->
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