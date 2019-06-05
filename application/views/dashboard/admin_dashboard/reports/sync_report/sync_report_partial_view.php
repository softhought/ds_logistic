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


<table id="SyncReportData" class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;">
               
                <tr class="projectHeading">
                  <td  colspan="100%" style="text-align:center;"><?php echo $tripReportProject.' '.$period; ?></td>
                </tr>              
                <tr class="projectHeading">
                  <td>Sl</td>
                  <td>Tipper</td>
                  <!--  <td>Last Modified</td> -->
                  <td>Sync Date</td>
              
                  <td>Mobile No</td>
                  <td>Mobile UID</td>
                     
                </tr>
               
                
                  <?php 
					// echo "<pre>";
					// print_r($tripReport);
					// echo "</pre>";
					
              		$i = 1;
              		foreach ($syncReport as $value) {                      
                                           
              		?>

					<tr>
		                    <td><?php echo $i; ?></td> 
                        <td><?php echo $value['tipperData']->equipment_name;?></td>
                      <!--   <td><?php echo date("d-m-Y H:i:s",strtotime($value['lastSync']->capture_on));?></td> -->
                        <td><?php 

                         if($value['lastSync']->last_modified!=NULL){
                            echo date("d-m-Y H:i:s",strtotime($value['lastSync']->last_modified));
                          }

                         ?></td>
                        <td><?php echo $value['lastSync']->mobile_no;?></td>
                        <td><?php echo $value['lastSync']->mobile_uuid;?></td>
                       
                       
                     
				    </tr>              			
              	<?php
                    $i++;
              		}
              	?>
               
               
              </table>


</div>