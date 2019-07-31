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
.hidetdth{
display: none!important;
}

</style>
<input type="hidden" name="distanceReportProject" id="distanceReportProject" value="<?php echo $distanceReportProject; ?>">

  <div class="download" id="download" style="display:block;">
              <button class="btn bg-purple btn-flat margin" name="downloadxls" id="downloadxls"  >Download Excel</button> 
              <button class="btn bg-olive btn-flat margin" onclick="printDiv('printarea')"  ><i class="fa fa-print" aria-hidden="true"></i>
  Print</button> 
  
            </div>
<div class="datatalberes" id="printarea" style="overflow-x:auto;">


<table id="DistanceReportData" class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;text-align: center;overflow-x: scroll;">
              
                <tr class="projectHeading">
                  <td  colspan="100%" style="text-align:center;"><?php echo $distanceReportProject.' '.$period; ?></td>
                </tr>              
                <tr class="projectHeading">
                  <td style="width:2%">Sl</td>
                  <td style="width:10%"><?php echo $vehicle;?></td>
                  <?php 
                        foreach ($shiftList as $shiftlist) {
                       
                    ?>
                  <td class="<?php echo $hidecolumn;?>" style="border-right:1px solid #0e8ac5 !important;"> </td>
                  <td style="border-right:1px solid #0e8ac5 !important;text-align: right;"><?php echo $shiftlist->shift_code;?></td>
                  <td class="<?php echo $hidecolumn;?>"  style="border-right:1px solid #0e8ac5 !important;"></td>
                  <td></td>
                <?php }?>
                <td class="<?php echo $hidecolumn;?>" style="width:5%"></td>
                <td  style="width:5%"></td>
                  
                 
                </tr>
               

                  <tr style="background-color: #0e8ac5;color: #fff;">
                    <td></td>
                    <td></td>

                    <?php 
                        foreach ($shiftList as $shiftlist) {
                       
                    ?>
                  <td class="<?php echo $hidecolumn;?>">Opening Km.</td>
                  <td class="<?php echo $hidecolumn;?>">Closing Km.</td>
                  <td>Opening Hour</td>
                  
                  <td>Closing Hour</td>
                <?php }?>

                    <td class="<?php echo $hidecolumn;?>">Total Km.</td>
                    <td>Total Hour</td>
                  </tr>
                
                  <?php 
					// echo "<pre>";
					// print_r($distanceReport);
					// echo "</pre>";
					
              		$i = 1;
              		foreach ($distanceReport as $distavcereport) {                      
                                           
              		?>

					<tr>
					              <td><?php echo $i; ?></td>
                        <td><?php echo $distavcereport['distanceMasterData']->equipment_name; ?></td>
                        <?php 
                        $rowtotalkm =0;
                        $rowtotalhour =0;
                        foreach ($distavcereport['shiftType'] as $shifttype) {
                          $shiftdiffkm=0;
                          $shiftdiffhour=0;
                        if($shifttype['distanceDetails']){

                          $shiftdiffkm =($shifttype['distanceDetails']->end_km-$shifttype['distanceDetails']->start_km);

                          $shiftdiffhour=($shifttype['distanceDetails']->end_time-$shifttype['distanceDetails']->start_time);
                         
                    ?>
                  <td class="<?php echo $hidecolumn;?>" style="text-align: right;"><?php echo $shifttype['distanceDetails']->start_km;?></td>
                  <td class="<?php echo $hidecolumn;?>" style="text-align: right;"><?php echo $shifttype['distanceDetails']->end_km;?></td>
                  <td><?php echo $shifttype['distanceDetails']->start_time;?></td>
                 
                  <td><?php echo $shifttype['distanceDetails']->end_time;?>
                    
                    
                  </td>
                      <?php }else{?>
                        <td class="<?php echo $hidecolumn;?>"></td>
                        <td class="<?php echo $hidecolumn;?>"></td>
                        <td></td>
                        <td></td>
                <?php } 

                $rowtotalkm+=$shiftdiffkm;
                $rowtotalhour+=$shiftdiffhour;

              }?>
                <td class="<?php echo $hidecolumn;?>" style="font-weight: bold;text-align: right;"> <?php echo number_format($rowtotalkm,2);?></td>
                 <td style="font-weight: bold;text-align: right;"><?php echo number_format($rowtotalhour,2);?></td>
                      
                        
				    </tr>              			
              	<?php
                    $i++;
              		}
              	?>
              
               
              </table>


</div>