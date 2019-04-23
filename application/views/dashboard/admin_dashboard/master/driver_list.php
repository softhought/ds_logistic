<?php //pre($bodycontent['driverList']); ?>

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
        <li class="active">Driver List</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

		    <div class="box">
            <div class="box-header">
              <h3 class="box-title">Driver List</h3>&nbsp;
              <!-- <a href="<?php echo base_url();?>contra/contra" class="link_tab"><span class="glyphicon glyphicon-plus"></span> ADD</a> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="datatalberes" style="overflow-x:auto;">
              <table id="example" class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;">
                <thead>
                <tr>
                  <th style="width:10%;">Sl</th>
                  <th>Driver Code</th>
                  <th>Driver Name</th>
                  <th>Working Project</th>
                  <th>Driver Password</th>
                  <th>Vehicle Type</th> 
                   
                 
                </tr>
                </thead>
                <tbody>
               
              	<?php 
				          
                      $i = 1;
                    //   pre($bodycontent['driverList']);
              		foreach ($bodycontent['driverList'] as $value) {                     
              		?>

					<tr>
						<td><?php echo $i; ?></td>
                        <td><?php echo $value->driver_code; ?></td>
                        <td><?php echo $value->driver_name; ?></td>
                        <td><?php echo $value->working_project_id; ?></td>
                        <td><?php echo $value->driver_password; ?></td>
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