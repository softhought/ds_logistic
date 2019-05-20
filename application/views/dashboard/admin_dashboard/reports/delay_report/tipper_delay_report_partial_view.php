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

</style>
<input type="hidden" name="tripReportProject" id="tripReportProject" value="<?php echo $tripReportProject; ?>">
<div class="datatalberes" style="overflow-x:auto;">


<table id="TripReportData" class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;">
                <thead> 
                <tr>
                  <th rowspan="1" colspan="8" style="text-align:center;"><?php echo $tripReportProject; ?></th>
                </tr>              
                <tr>
                  <th>Sl</th>
                  <th>Tipper</th>
                  <th>Login Time</th>
                  <th  align="center">Shift</th>
                  <th>First Trip Start</th>
                  <th>Start Ideal Time</th>
                  <th>Last Trip End</th>
                  <th>End Ideal Time</th>
                 
                 
                </tr>
                </thead>
                <tbody>
                
                  <?php 
					// echo "<pre>";
					// print_r($driverReport);
					// echo "</pre>";
					
              		$i = 1;
              		foreach ($tipperDelayReport as $value) {                      
                       // date ('H:i:s',strtotime($value['startIdelTime']->login_time))                   
              		?>

					<tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $value['tipperData']->equipment_name; ?></td>
                         <!--  <input type="text" value="<?php echo $value['excavatorData']->equipment_id; ?>"> -->
                        <td><?php if($value['startIdelTime']->login_time!=''){echo date ('H:i:s',strtotime($value['startIdelTime']->login_time)); }?></td>
                        <td><?php echo $value['startIdelTime']->shift_code; ?></td>
                        <td><?php if($value['startIdelTime']->session_satrt_time!=''){echo date ('H:i:s',strtotime($value['startIdelTime']->session_satrt_time)); }?></td>
                       
                        <td><?php

                           $shiftStart = strtotime($value['startIdelTime']->start_time);
                           $firstTripStart = strtotime(date('H:i:s',strtotime($value['startIdelTime']->session_satrt_time)));

                           echo $stIdelTime = round(abs($firstTripStart - $shiftStart) / 60,2). " minute";
                          

                        ?>
                          
                        </td>
                       <td><?php if($value['endIdelTime']->session_end_time!=''){echo date ('H:i:s',strtotime($value['endIdelTime']->session_end_time)); }?></td>

                        <td><?php

                           $shiftEnd = strtotime($value['endIdelTime']->end_time);
                           $lastTripEnd = strtotime(date('H:i:s',strtotime($value['endIdelTime']->session_end_time)));

                           if ($value['endIdelTime']->session_end_time!='') {
                               echo $endIdelTime = round(abs($lastTripEnd - $shiftEnd) / 60,2). " minute";
                           }
                         
                          

                        ?>
                          
                        </td>
					             
                      
                        
				    </tr>              			
              	<?php
                    $i++;
              		}
              	?>
                </tbody>
               
              </table>


</div>