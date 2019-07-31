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
              <button class="btn bg-olive btn-flat margin" onclick="printDiv('printarea')"  ><i class="fa fa-print" aria-hidden="true"></i>
  Print</button> 
  
            </div>
<div class="datatalberes" id="printarea" style="overflow-x:auto;">


<table id="TripReportData" class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;">
               
                <tr class="projectHeading"><td colspan="10"><?php echo $tipperdumpReport.' '.$period; ?></td>
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
                  <td>Total</td>
                   
                </tr>
             
                
                  <?php 
					// echo "<pre>";
					// print_r($tripReport);
					// echo "</pre>";
					
              		$i = 1;
                  $totalHour=0;
                  $totalMinute=0;
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

            <td><?php

                   $TripStart = strtotime(date('H:i:s',strtotime($value->session_satrt_time)));
                   $TripEnd = strtotime(date('H:i:s',strtotime($value->session_end_time)));
                   $TripTime= abs(floor(($TripEnd - $TripStart)/60));

                   // for check 31.07.2019
                    if ($value->shift_code=='C') {
                                    
                                      $timetripst = '00:00:00';
                                      $endhour = '23:59:59';
                                     //strtotime($timetripst);
                                     if($TripStart > $TripEnd){

                                      $TripTime = (1440-$TripTime);  // 24*60
                                     }
                                   
                    }


                    if ($TripTime>60 || $TripTime<-60) {

                               $tripTimeHour = floor($TripTime/60);
                               $tripTimeMin = ($TripTime%60);
                               $totalMinute+=$tripTimeMin;
                               $totalHour+=$tripTimeHour;

                                if ($tripTimeMin!=0) {
                                  echo $tripTimeHour. " hour " .$tripTimeMin. "  minute";
                                }else{
                                   echo $tripTimeHour. "hour";
                                }
                                 

                            }else{
                                echo $TripTime. " minute";
                                $totalMinute+=$TripTime;
                            }

            ?>
              

            </td> 
                       
				    </tr>              			
              	<?php
                    $i++;
              		}
              	?>

                <tr>
                  <td>Total</td>
                  <td colspan="8"></td>
                   <td><?php

                  
                   

                      if ($totalMinute>60 || $totalMinute<-60) {

                               $totalHour += floor($totalMinute/60);
                               $totalMinute = ($totalMinute%60);
                               

                                if ($totalMinute!=0) {
                                  echo $totalHour. " hour " .$totalMinute. "  minute";
                                }else{
                                   echo $totalHour. "hour";
                                }
                                 

                            }else{
                                echo $totalMinute. " minute";
                               
                            }


                   ?></td>
                </tr>
             
               
              </table>


</div>