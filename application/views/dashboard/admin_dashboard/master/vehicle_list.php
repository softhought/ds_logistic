<?php //pre($bodycontent['vehicleList']); ?>

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
              <!-- <a href="<?php echo base_url();?>contra/contra" class="link_tab"><span class="glyphicon glyphicon-plus"></span> ADD</a> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="datatalberes" style="overflow-x:auto;">
              <table id="example" class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;">
                <thead>
                <tr>
                  <th style="width:10%;">Sl</th>
                  <th>Equipment Id</th>
                  <th>Project Id</th>
                  <th>Mobile Id</th>
                  <th>Equipment Name</th>
                  <th>Equipment Model</th>
                  <th>Vehicle Type</th>                  
                </tr>
                </thead>
                <tbody>
               
              	<?php 
				          
                      $i = 1;
                    //   pre($bodycontent['driverList']);
              		foreach ($bodycontent['vehicleList'] as $value) {                     
              		?>

					<tr>
						<td><?php echo $i; ?></td>
                        <td><?php echo $value->equipment_id; ?></td>
                        <td><?php echo $value->project_id; ?></td>                                              
                        <td><?php echo $value->mobile_uuid; ?></td>  
                        <td><?php echo $value->equipment_name; ?></td>
                        <td><?php echo $value->equipment_model; ?></td>
                        <td><?php echo $value->vehicle_type; ?></td>                                              
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