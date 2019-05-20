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
<input type="hidden" name="distanceReportProject" id="distanceReportProject" value="<?php echo $distanceReportProject; ?>">
<div class="datatalberes" style="overflow-x:auto;">


<table id="DistanceReportData" class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;text-align: center;">
                <thead> 
                <tr>
                  <th rowspan="1" colspan="16" style="text-align:center;"><?php echo $distanceReportProject; ?></th>
                </tr>              
                <tr>
                  <th style="width:2%">Sl</th>
                  <th style="width:10%"><?php echo $vehicle;?></th>
                  <?php 
                        foreach ($shiftList as $shiftlist) {
                       
                    ?>
                  <th style="border-right: 0px"> </th>
                  <th style="border-right: 0px;text-align: right;"><?php echo $shiftlist->shift_code;?></th>
                  <th style="border-right: 0px"></th>
                  <th></th>
                <?php }?>
                <th style="width:5%"></th>
                <th style="width:5%"></th>
                  
                 
                </tr>
                </thead>
                <tbody>

                  <tr style="background-color: #0e8ac5;color: #fff;">
                    <td></td>
                    <td></td>

                    <?php 
                        foreach ($shiftList as $shiftlist) {
                       
                    ?>
                  <td>Opening Km.</td>
                  <td>Opening Hour</td>
                  <td>Closing Km.</td>
                  <td>Closing Hour</td>
                <?php }?>

                    <td>Total Km.</td>
                    <td>Total Hour</td>
                  </tr>
                
                  <?php 
					// echo "<pre>";
					// print_r($driverReport);
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
                  <td><?php echo $shifttype['distanceDetails']->start_km;?></td>
                  <td><?php echo $shifttype['distanceDetails']->start_time;?></td>
                  <td><?php echo $shifttype['distanceDetails']->end_km;?></td>
                  <td><?php echo $shifttype['distanceDetails']->end_time;?>
                    
                    
                  </td>
                      <?php }else{?>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                <?php } 

                $rowtotalkm+=$shiftdiffkm;
                $rowtotalhour+=$shiftdiffhour;

              }?>
                <td style="font-weight: bold;"> <?php echo $rowtotalkm;?></td>
                 <td style="font-weight: bold;"><?php echo $rowtotalhour;?></td>
                      
                        
				    </tr>              			
              	<?php
                    $i++;
              		}
              	?>
                </tbody>
               
              </table>


</div>