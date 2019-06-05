<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">


<style>
#contralist td{
vertical-align: inherit;
}
.table-bordered {
  border: 1px solid #aeaeae;
}
.table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
  border: 1px solid #aeaeae;
}

.projectHeading{
  text-align: center;
  font-weight: bold;
  background-color: #0e8ac5!important;
  color: #FFF !important;
}


</style>
<input type="hidden" name="tipperdumpReport" id="tipperdumpReport" value="<?php echo $tipperdumpReport; ?>">
<div class="download" id="download" style="display:block;">
              <button class="btn bg-purple btn-flat margin" name="downloadxls" id="downloadxls"  >Download XLS</button> 
            </div>
<div class="datatalberes" style="overflow-x:auto;">


<table id="TripReportData" class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;">
               
                <tr class="projectHeading"><td colspan="9"><?php echo $tipperdumpReport.' '.$period; ?></td>
                </tr>                
                <tr class="projectHeading">
                 <td>Sl</td> 
                 <td>Material Type</td> 
                  <td>Date</td>
                  <td>Shift</td>
                  <td>Tipper No.</td>
                  <td>Loaded By</td>
                  <td>Dumping Yard</td>
                  <td>Start Time</td>
                  <td>End Time</td>
                   
                </tr>
             
                
                  <?php 
					// echo "<pre>";
					// print_r($tripReport);
					// echo "</pre>";
					
              		$i = 1;
              		foreach ($reportData as $value) {                      
                                           
              		?>

					<tr >
						<td><?php echo $i; ?></td> 
            <td><?php echo $value->material_type; ?></td>
             <td><?php echo date('d-m-Y',strtotime($value->shift_date)); ?></td>
             <td><?php echo $value->shift_code; ?></td>
             <td><?php echo $value->equipment_name; ?></td>
             <td><?php echo $value->excavator; ?></td>
             <td><?php echo $value->dumping_yard_name; ?></td>
             <td><?php echo date ('H:i:s',strtotime($value->session_satrt_time)) ;?></td>
            <td><?php echo date ('H:i:s',strtotime($value->session_end_time)) ;?></td>
                       
				    </tr>              			
              	<?php
                    $i++;
              		}
              	?>
             
               
              </table>


</div>