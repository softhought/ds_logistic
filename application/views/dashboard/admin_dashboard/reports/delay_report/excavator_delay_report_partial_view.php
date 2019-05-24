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
 <div class="download" id="download" style="display:block;">
              <button class="btn bg-purple btn-flat margin" name="downloadxls" id="downloadxls"  >Download Excel</button> 
            </div>
<div class="datatalberes" style="overflow-x:auto;">


<table id="TripReportData" class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;">
                
                <tr class="projectHeading">
                  <td  colspan="100%" style="text-align:center;"><?php echo $tripReportProject.' '.$period; ?></td>
                </tr>              
                <tr class="projectHeading">
                  <td>Sl</td>
                  <td>Excavator</td>
                  <td align="center">Shift</td>
                  <td>First Trip Start</td>
                  <td>Start Ideal Time</td>
                  <td>Last Trip End</td>
                  <td>End Ideal Time</td>
                 
                 
                </tr>
               
                
                  <?php 
					// echo "<pre>";
					// print_r($driverReport);
					// echo "</pre>";
					
              		$i = 1;
              		foreach ($excavatorDelayReport as $value) {                      
                                           
              		?>

					<tr>
					              <td><?php echo $i; ?></td>
                         <td><?php echo $value['excavatorData']->equipment_name; ?>
                          <!--  <input type="text" value="<?php echo $value['excavatorData']->equipment_id; ?>"> -->
                         </td>
                          
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
               
               
              </table>


</div>