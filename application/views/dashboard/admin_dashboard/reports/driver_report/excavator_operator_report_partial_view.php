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
                  <th rowspan="1" colspan="5" style="text-align:center;"><?php echo $tripReportProject; ?></th>
                </tr>              
                <tr>
                  <th>Sl</th>
                  <th>Operator</th>
                  <th>Sum of Counter</th>
              
                 
                </tr>
                </thead>
                <tbody>
                
                  <?php 
					// echo "<pre>";
					// print_r($driverReport);
					// echo "</pre>";
					
              		$i = 1;
              		foreach ($operatorReport as $value) {                      
                                           
              		?>

					<tr>
					              <td><?php echo $i; ?></td>
                        <td><?php echo $value['operatorData']->driver_name; ?></td>
                        <td><?php echo $value['tripCountshiftType'];?></td>
                       
                        
				    </tr>              			
              	<?php
                    $i++;
              		}
              	?>
                </tbody>
               
              </table>


</div>