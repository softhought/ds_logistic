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
              <button class="btn bg-olive btn-flat margin" onclick="printDiv('printarea')"  ><i class="fa fa-print" aria-hidden="true"></i>
  Print</button>
            </div>
<div class="datatalberes" id="printarea" style="overflow-x:auto;">


<table id="TripReportData" class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;">
                
                <tr class="projectHeading">
                  <td colspan="100%" style="text-align:center;"><?php echo $tripReportProject.' '.$period; ?></td>
                </tr>              
                <tr class="projectHeading">
                  <td>Sl</td>
                  <td>Tipper</td>
                  <td>Login Time</td>
                  <td  align="center">Shift</td>
                  <td>First Trip Start</td>
                  <td>Start Idle Time</td>
                  <td>Last Trip End</td>
                  <td>End Idle Time</td>
                 
                 
                </tr>
               
                
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
                           $lastTripEnd = strtotime(date('H:i:s',strtotime($value['endIdelTime']->session_end_time)));

                          // echo $stIdelTime = round(abs($firstTripStart - $shiftStart) / 60,2). " minute";

                            $stIdelTime= abs(floor(($firstTripStart - $shiftStart)/60));


                               if ($value['startIdelTime']->shift_code=='C') {
                                    
                                      $timetripst = '00:00:00';
                                     //strtotime($timetripst);
                                     if($firstTripStart >= strtotime($timetripst) && $firstTripStart<=$lastTripEnd){

                                      $stIdelTime = (1440-$stIdelTime);  // 24*60
                                     }
                                   
                                  }

                            if ($stIdelTime>60 || $stIdelTime<-60) {

                               $stIdelTimeHour = floor($stIdelTime/60);
                               $stIdelTimeMin = ($stIdelTime%60);

                                if ($stIdelTimeMin!=0) {
                                  echo $stIdelTimeHour. " hour " .$stIdelTimeMin. "  minute";
                                }else{
                                   echo $stIdelTimeHour. "hour";
                                }
                                 

                            }else{
                                echo $stIdelTime. " minute";
                            }
                          
                          

                        ?>
                          
                        </td>
                       <td><?php if($value['endIdelTime']->session_end_time!=''){echo date ('H:i:s',strtotime($value['endIdelTime']->session_end_time)); }?></td>

                        <td><?php

                           $shiftEnd = strtotime($value['endIdelTime']->end_time);
                           $lastTripEnd = strtotime(date('H:i:s',strtotime($value['endIdelTime']->session_end_time)));

                           if ($value['endIdelTime']->session_end_time!='') {
                              
                              // echo $endIdelTime = round(abs($lastTripEnd - $shiftEnd) / 60,2). " minute";

                                $endIdelTime= abs(floor(($lastTripEnd-$shiftEnd)/60));

                                    if ($value['startIdelTime']->shift_code=='C') {
                                    
                                      $timetrip = '23:59:59';
                                     strtotime($timetrip);
                                     $lastTripEnd;

                                     if($lastTripEnd >= $shiftStart && $lastTripEnd <= strtotime($timetrip)){

                                      $endIdelTime = (1440-$endIdelTime);  // 24*60
                                     }

                                   
                                  }

                                if($endIdelTime>60 || $endIdelTime<-60){
                                  $endIdelTimeHour=floor($endIdelTime/60);
                                  $endIdelTimeMin = ($endIdelTime%60);

                                     if ($endIdelTimeMin!=0) {
                                        echo $endIdelTimeHour. " hour " .$endIdelTimeMin. "  minute";
                                      }else{
                                         echo $endIdelTimeHour. "hour";
                                      }

                                }else{

                                     echo $endIdelTime. " minute";
                                }
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