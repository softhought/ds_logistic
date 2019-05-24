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
<input type="hidden" name="tripReportProject" id="tripReportProject" value="<?php echo $quantityReportProject; ?>">
 <div class="download" id="download" style="display:block;">
              <button class="btn bg-purple btn-flat margin" name="downloadxls" id="downloadxls"  >Download XLS</button> 
            </div>
<div class="datatalberes" style="overflow-x:auto;">


<table id="tipperreport" class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;text-align: center;overflow-x: scroll;">
              
                <tr class="projectHeading">
                  <td  colspan="100%" style="text-align:center;"><?php echo $quantityReportProject.''.$period; ?></td>
                </tr>              
                <tr class="projectHeading">
                  <td>Sl</td> 
                  <td >Tipper</td>
                  <?php 
                 $shiftCount=count($shift );

                  foreach ($materialList as $materiallist) {
                    for ($i=0; $i < $shiftCount; $i++) { 
                     $previous=$materiallist->material;
                   ?>

                     <td  style="text-align: center;">
                      <?php if($i==0){echo $materiallist->material;}?></td> <?php }?>

                     <td> <?php echo $materiallist->material.' Total';?></td>
                 <?php }
                  ?>
                
                </tr>

               


            


               
               

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
                        <td align="left" style="width: 10%"><?php echo $tipperawisereport['tipperData']->equipment_name; ?></td>
                                  
                           <?php  foreach ($tipperawisereport['materialType'] as $materialtype) { 
                                       
                                        $materialwiseShiftTotal=0;
                                       foreach($materialtype['shiftType'] as $shiftType) {
                                        $materialwiseShiftTotal+=$shiftType['shiftTripQuantity'];
                             ?>
                                          <td style="text-align: right;"><?php  

                                           // set column total
                                            if(!array_key_exists($index, $colTripCount)) {$colTripCount[$index]=0;}
                                            $colTripCount[$index]+=$shiftType['shiftTripQuantity'];
                                            $index++;

                                          echo number_format($shiftType['shiftTripQuantity'],2); ?></td>
                         
                                      <?php } 
                                          $rowGrandTotal+=$materialwiseShiftTotal;

                                      ?>
                                        <td style="font-weight: bold;text-align: right;"> <?php 
                                        
                                        // set column total
                                        if(!array_key_exists($index, $colTripCount)) {$colTripCount[$index]=0;}
                                            $colTripCount[$index]+=$materialwiseShiftTotal;
                                            $index++;


                                        echo number_format($materialwiseShiftTotal,2); ?></td>
                           <?php } ?>


                      
                       
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
                         <td style="text-align: right;"><?php echo number_format($columntotal,2);?> </td>   
                <?php      }
                 ?>
                 </tr> 
               
               
              </table>


</div>