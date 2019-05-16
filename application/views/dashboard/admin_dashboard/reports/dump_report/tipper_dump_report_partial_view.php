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
<input type="hidden" name="tipperdumpReport" id="tipperdumpReport" value="<?php echo $tipperdumpReport; ?>">
<div class="datatalberes" style="overflow-x:auto;">


<table id="TripReportData" class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;">
                <thead> 
                <tr>
                  <th rowspan="1" colspan="9" style="text-align:center;"><?php echo $tipperdumpReport; ?></th>
                </tr>              
                <tr>
                 <th>Sl</th> 
                 <th>Material Type</th> 
                  <th>Shift Date</th>
                  <th>Shift Code</th>
                  <th>Tipper</th>
                  <th>Excavator</th>
                  <th>Dumping Yard</th>
                  <th>Start Time</th>
                  <th>End Time</th>
                   
                </tr>
                </thead>
                <tbody>
                
                  <?php 
					// echo "<pre>";
					// print_r($tripReport);
					// echo "</pre>";
					
              		$i = 1;
              		foreach ($reportData as $value) {                      
                                           
              		?>

					<tr>
						<td><?php echo $i; ?></td> 
            <td><?php echo $value->material_type; ?></td>
             <td><?php echo date('d-m-Y',strtotime($value->shift_date)); ?></td>
             <td><?php echo $value->shift_code; ?></td>
             <td><?php echo $value->equipment_name; ?></td>
             <td><?php echo $value->excavator; ?></td>
             <td><?php echo $value->dumping_yard_name; ?></td>
             <td><?php echo date ('H:i:s',strtotime($value->session_satrt_time)) ;?></td>
            <td><?php echo date ('H:i:s',strtotime($value->session_end_time)) ;?></td>
                       
				    </tr>              			
              	<?php
                    $i++;
              		}
              	?>
                </tbody>
               
              </table>


</div>