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
<input type="hidden" name="tripReportProject" id="tripReportProject" value="<?php echo $tripReportProject; ?>">
<div class="download" id="download" style="display:block;">
              <button class="btn bg-purple btn-flat margin" name="downloadxls" id="downloadxls"  >Download XLS</button> 
            </div>
<div class="datatalberes" style="overflow-x:auto;">


<table id="reporttable" class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;">
               
          <tr class="projectHeading"><td colspan="7"><?php echo $tripReportProject.' '.$period; ?></td>
          </tr>                 
                <tr class="projectHeading">
                  
                  <td>&nbsp;</td>
                 <?php 
                  
                  foreach ($lead_lift_report as $lead_lift) {
                      $t=0;
                      foreach ($materialList as $materiallist) {
                   ?>

                     <td  style="text-align: center;">
                      <?php if($t==0){echo $lead_lift->column_type;}?></td> 

                 <?php $t++;
                     }
                   }
                  ?>
                   
                </tr>
               
               

                           <tr class="projectHeading">
                        
                        <td>&nbsp;</td>
                       <?php 
                       
                        foreach ($lead_lift_report as $lead_lift_b) {
                        foreach ($materialList as $material) {
                         ?>

                           <td  style="text-align: center;">
                            <?php echo $material->material;?></td> 

                       <?php 
                           }
                         }
                        ?>
                         
                      </tr>
                
                  <?php 
					// echo "<pre>";
					// print_r($tripReport);
					// echo "</pre>";
					
              		$i = 1;
                  $shift='';
                  $excavatorCntByshift=0;
                   $columnLead=[];
              		foreach ($excawiseLeadLift as $excawiseLeadLift) { 
                       
                        $excavatorCntByshift = count($excawiseLeadLift['excavatorList']);                    
              		?>
                    <tr style="font-weight: bold;">
                                <td><?php echo 'Shift - '.$excawiseLeadLift['shift']->shift_code; ?></td>
                                <?php 
                                 
                                  foreach ($lead_lift_report as $lead_lift_c) {
                                  foreach ($materialList as $material_list) {
                                   ?>

                                     <td  style="text-align: center;">&nbsp; </td> 

                                 <?php 
                                     }
                                   }
                                  ?>
                               
                    </tr>
                        <?php

                              foreach ($excawiseLeadLift['excavatorList'] as $excavatorList) {
                                $index=0;
                        ?>
        					  <tr>
        						
                                <td><?php echo $excavatorList['excavator']->equipment_name; ?></td>
                                <?php 
                                foreach ($excavatorList['LeadLiftColumn'] as $leadliftcolumn) {

                                     foreach ($leadliftcolumn['materialType'] as $meterialtype) {

                                           // set column total
                                            if(!array_key_exists($index, $columnLead)) {$columnLead[$index]=0;}
                                            $columnLead[$index]+=$meterialtype['LeadData'];
                                            $index++;

                                ?>
                                <td style="text-align: right;"><?php echo $meterialtype['LeadData'];?></td>
                              <?php }}?>
                              
                                
        				    </tr>  <?php }?> 
                    <tr style="background-color: #B69797;color: #fff;font-weight: bold;">
                      <td>Average</td>
                      <?php 
                                if($excavatorCntByshift!=0){
                               //  pre($columnLead);
                                    $newcolumnLead=$columnLead;
                                    foreach ($newcolumnLead as  $newcolumnLead) { 
                                      ?>
                                       <td style="text-align: right;"><?php 
                                       
                                            echo number_format($newcolumnLead/$excavatorCntByshift,2);
                                      
                                       
                                       ?> </td>   
                              <?php      } 

                                      }else{

                                 
                                              foreach ($lead_lift_report as $lead_lift_c) {
                                                  foreach ($materialList as $material_list) {
                                               ?>

                                                 <td  style="text-align: right;">&nbsp; </td> 

                                             <?php 
                                                   }
                                               }
                                 
                                      }
                               ?>
                    </tr>           			
              	<?php
                     $columnLead = array_fill_keys(array_keys($columnLead), 0);
                    $i++;
              		}
                  
              	?>

              
               
              </table>


</div>