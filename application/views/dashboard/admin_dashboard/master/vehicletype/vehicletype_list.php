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
        <li class="active">Vehicletype List</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

		    <div class="box">
            <div class="box-header">
              <h3 class="box-title">Vehicle Type List</h3>&nbsp;
              <a href="<?php echo base_url();?>vehicletype/addVehicletype" class="link_tab"><span class="glyphicon glyphicon-plus"></span> ADD</a> 
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="datatalberes" style="overflow-x:hidden;">
              <table id="example" class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;">
                <thead>
                <tr>
                  <th style="width:5%;">Sl</th>
                  <th style="width:10%;">Action</th>
                  <th>Type</th>
                </tr>
                </thead>
                <tbody>
               
              	<?php 
				          
                      $i = 1;
                      foreach ($bodycontent['vehicleTypeList'] as $value) {                     
              	?>

					          <tr>
						            <td><?php echo $i; ?></td>
                        <td>
                          <a href="<?php echo base_url(); ?>vehicletype/addVehicletype/<?php echo $value->vehicle_type_id; ?>" class="btn btn-primary btn-xs" data-title="Edit">
                            <span class="glyphicon glyphicon-pencil"></span>
                          </a>
                        </td>
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