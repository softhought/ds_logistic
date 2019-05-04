<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">


<style>

.headrow {
    font-weight: 400 !important;
    font-family: verdana;
    font-size: 11px;
    // background: #a800ff;
    background-color: #0e8ac5 !important;
    color: #FFF !important;
}

</style>
<input type="hidden" name="tripReportProject" id="tripReportProject" value="<?php echo $tripReportProject; ?>">
<div class="datatalberes" style="overflow-x:auto;">


<table id="tipperreport" class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;text-align: center;">
                <thead> 
                <!-- <tr>
                  <th rowspan="1" colspan="5" style="text-align:center;"><?php echo $tripReportProject; ?></th>
                </tr> -->              
                <tr>
                  <th>Sl</th> 
                  <th >Tipper</th>
                  <?php 
                 $shiftCount=count($shift );

                  foreach ($materialList as $materiallist) {
                    for ($i=0; $i < $shiftCount; $i++) { 
                     $previous=$materiallist->material;
                   ?>

                     <th  style="text-align: center;">
                      <?php if($i==0){echo $materiallist->material;}?></th> <?php }?>

                     <th> <?php echo $materiallist->material.' Total';?></th>
                 <?php }
                  ?>
                  <th >Grand Total</th>     
                </tr>

               


            


                </thead>
                <tbody>

                     <tr class="headrow">
                
                   <td></td> 
                   <td></td>
                  <?php 
                 
                  foreach ($materialList as $materialList) { 
                        foreach ($shift as $shiftloop) {
                          
                       
                    ?>
                     <td><?php echo $shiftloop->shift_code;?></td>
                    
                        <?php } ?> 
                    <td> </td>
                   <?php  } ?>
                   <td> </td>
                </tr>
                
                  <?php 
					// echo "<pre>";
					// print_r($shiftloop);
					// echo "</pre>";
					
              		$i = 1;
                  $colTripCount=[];
              		foreach ($tipperawiseReport as $tipperawisereport) {                      
                                $rowGrandTotal=0;
                                $index=0;  
                              //  $colTripCount[0]=10;
                             
                            //   echo $colTripCount[$index];;

              		?>

					<tr>
						           <td><?php echo $i; ?></td>
                        <td align="left"><?php echo $tipperawisereport['tipperData']->equipment_name; ?></td>
                                  
                           <?php  foreach ($tipperawisereport['materialType'] as $materialtype) { 
                                       
                                        $materialwiseShiftTotal=0;
                                       foreach($materialtype['shiftType'] as $shiftType) {
                                        $materialwiseShiftTotal+=$shiftType['shiftTripCount'];
                             ?>
                                          <td><?php  

                                           // set column total
                                            if(!array_key_exists($index, $colTripCount)) {$colTripCount[$index]=0;}
                                            $colTripCount[$index]+=$shiftType['shiftTripCount'];
                                            $index++;

                                          echo $shiftType['shiftTripCount']; ?></td>
                         
                                      <?php } 
                                          $rowGrandTotal+=$materialwiseShiftTotal;

                                      ?>
                                        <td style="font-weight: bold;"> <?php 
                                        
                                        // set column total
                                        if(!array_key_exists($index, $colTripCount)) {$colTripCount[$index]=0;}
                                            $colTripCount[$index]+=$materialwiseShiftTotal;
                                            $index++;


                                        echo $materialwiseShiftTotal; ?></td>
                           <?php } ?>


                           <td style="font-weight: bold;color: #0a9b0a;"><?php 
                          // set column total
                           if(!array_key_exists($index, $colTripCount)) {$colTripCount[$index]=0;}
                           $colTripCount[$index]+=$rowGrandTotal;
                           $index++;

                           echo $rowGrandTotal; ?></td>
                       
				    </tr>              			
              	<?php
                    $i++;
              		}
              	?>

                <tr style="font-weight: bold;color: #0a9b0a;">
                  <td></td>
                  <td align="left">Grand Total </td>
                
                <?php
                    //  print_r($colTripCount);
                      foreach ($colTripCount as $key => $columntotal) { ?>
                         <td><?php echo $columntotal;?> </td>   
                <?php      }
                 ?>
                 </tr> 
                </tbody>
               
              </table>


</div>