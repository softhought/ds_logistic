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
              <button class="btn bg-purple btn-flat margin" name="TripReportdownloadxls" id="TripReportdownloadxls"  >Download XLS</button> 
            </div>
<div class="datatalberes" style="overflow-x:auto;">


<table id="TripReportData" class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;">
                
                <tr class="projectHeading">
                  <td  colspan="100%" style="text-align:center;"><?php echo $tripReportProject.' '.$period; ?></td>
                </tr>              
                <tr class="projectHeading">
                  <!-- <th>Sl</th> -->
                  <td>Material</td>
                  <td>A</td>
                  <td>B</td>
                  <td>C</td>
                  <td>Total</td>      
                </tr>
              
                
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
                        <td style="text-align: right;"><?php echo number_format($value['A'],2); ?></td>
                        <td style="text-align: right;"><?php echo number_format($value['B'],2); ?></td>
                        <td style="text-align: right;"><?php echo number_format($value['C'],2); ?></td>
                        <td style="text-align: right;"> <?php echo number_format($value['Total'],2); ?></td>
				    </tr>              			
              	<?php
                    $i++;
              		}
              	?>
             
               
              </table>


</div>