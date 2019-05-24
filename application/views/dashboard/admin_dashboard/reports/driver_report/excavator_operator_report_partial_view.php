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
              <button class="btn bg-purple btn-flat margin" name="downloadxls" id="downloadxls"  >Download XLS</button> 
            </div>
<div class="datatalberes" style="overflow-x:auto;">


<table id="TripReportData" class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;">
               
                <tr class="projectHeading">
                  <td  colspan="100%" style="text-align:center;"><?php echo $tripReportProject.' '.$period; ?></td>
                </tr>              
                <tr class="projectHeading">
                  <td>Sl</td>
                  <td>Operator</td>
                  <td>Sum of Counter</td>
              
                 
                </tr>
               
                
                  <?php 
					// echo "<pre>";
					// print_r($driverReport);
					// echo "</pre>";
					
              		$i = 1;
                  $totalTrip=0;
              		foreach ($operatorReport as $value) {  
                  $totalTrip+=$value['tripCountshiftType'];;                    
                                           
              		?>

					<tr>
					              <td><?php echo $i; ?></td>
                        <td ><?php echo $value['operatorData']->driver_name; ?></td>
                        <td style="text-align: right;"><?php echo $value['tripCountshiftType'];?></td>
                       
                        
				    </tr>              			
              	<?php
                    $i++;
              		}
              	?>
               
                <tr style="font-weight: bold;">
                 <td colspan="2">Grand Total</td>
                 <td style="text-align: right;"><?php echo $totalTrip;?></td>
                
               </tr>
              </table>


</div>