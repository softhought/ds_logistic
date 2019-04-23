<script src="<?php echo base_url(); ?>assets/js/adm_scripts/driver.js"></script>  
<style>
#contralist td{
vertical-align: inherit;
}

.excavatorerror{
  border: 1px solid #dd4b39!important;
}
</style>
   <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Trip-Excavator</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

		    <div class="box">
            <div class="box-header">
              <h3 class="box-title">Trip-Excavator Mapping List</h3>&nbsp;
            
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="datatalberes" style="overflow-x:hidden;">
              <table id="example" class="table table-bordered table-striped dataTables" >
                <thead>
                <tr>
                 
                  <th style="width:5%;">Sl</th>
                  <th>Project</th>
                  <th>Date</th>
                  <th>Shift</th>
                  <th>Driver Name</th>
                  <th>Excavator Name</th>
                  <th>Equipment Id</th>
                  <th>Equipment Model</th>
                 
                 
                </tr>
                </thead>
                <tbody>
               
              	<?php 
				          
                      $i = 1;
                    //   pre($bodycontent['tripexcavatorList']);
              		foreach ($bodycontent['tripexcavatorList'] as $value) {    
                    
                    if($value->shift_date!=''){
                      $shift_date=date('d-m-Y',strtotime($value->shift_date)); 
                    }else{
                      $shift_date='';
                    }

                    if($value->equipment_id==NULL){
                        $applyClass='excavatorerror';
                    }else{
                      $applyClass='';
                    }

              		?>

					<tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $value->project_nickname; ?></td>
                        <td><?php echo $shift_date; ?></td>
                        <td><?php echo $value->shift_code; ?></td>
                        <td><?php echo $value->driver_name; ?></td>
                        <td class="<?php echo $applyClass;?>"><?php echo $value->equipment_name; ?></td>
                        <td class="<?php echo $applyClass;?>"><?php echo $value->equipment_id; ?></td>
                        <td class="<?php echo $applyClass;?>"><?php echo $value->equipment_model; ?></td>
                     

                       
                         
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