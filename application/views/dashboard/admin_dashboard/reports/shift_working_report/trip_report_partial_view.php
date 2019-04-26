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

<div class="datatalberes" style="overflow-x:auto;">


<table id="TripReportData" class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;">
                <thead>
                <tr>
                  <!-- <th>Sl</th> -->
                  <th>Material</th>
                  <th>A</th>
                  <th>B</th>
                  <th>C</th>
                  <th>Total</th>      
                </tr>
                </thead>
                <tbody>
               
                  <?php 
					// echo "<pre>";
					// print_r($tripReport);
					// echo "</pre>";
					
              		$i = 1;
              		foreach ($tripReport as $value) {                      
                                           
              		?>

					<tr>
						<!-- <td><?php echo $i; ?></td> -->
                        <td><?php echo $value['materialType']; ?></td>
                        <td><?php echo $value['A']; ?></td>
                        <td><?php echo $value['B']; ?></td>
                        <td><?php echo $value['C']; ?></td>
                        <td><?php echo $value['Total']; ?></td>
				    </tr>              			
              	<?php
                    $i++;
              		}
              	?>
                </tbody>
               
              </table>


</div>