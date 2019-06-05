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
.reset{
  color: #ea6426!important;
}

#response_message{
  font-size: 18px;
margin: 0px auto;
text-align: center;
font-weight: bold;
color: gray;
}


.hidetdth{
display: none!important;
}
input{
  width: 115px;
}
</style>
<hr>
<div style="margin-bottom: 10px;font-size: 15px;">
  <span class="label label-danger"><?php echo $project;?></span>
  <span class="label label-info"><?php  echo $vehicle_type;?></span>
  <span class="label label-warning">Observer : <?php  echo $observer;?></span>
   <span class="label label-primary" style="background-color: #3c50c3 ;">Shift Date : <?php  echo $shiftdate;?></span>
  <span class="label label-success">Shift : <?php  echo $shift;?></span>
</div>
<input type="hidden" name="sheet" value="add/edit">
<div class="datatalberes" style="overflow-x:auto;">

    <form action="#" name="VehicleDistDetails" id="VehicleDistDetails">
   <input type="hidden" name="allinputreadonly" id="allinputreadonly" value="<?php echo $allinputreadonly;?>">
      <input type="hidden" name="mode" id="mode" value="<?php echo $mode;?>">
      <input type="hidden" name="distancemstID" id="distancemstID" value="<?php echo $distancemstID;?>">
      <input type="hidden" name="projectid" id="projectid" value="<?php echo $projectid;?>">
      <input type="hidden" name="vehicle_type_id" id="vehicle_type_id" value="<?php echo $vehicle_type_id;?>">
      <input type="hidden" name="observerid" id="observerid" value="<?php echo $observerid;?>">
      <input type="hidden" name="shiftdate" id="shiftdate" value="<?php echo $shiftdate;?>">
      <input type="hidden" name="shift" id="shift" value="<?php echo $shift;?>">


<table id="TripReportData" class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;">
                <thead> 
                          
                <tr>
                 <th>Sl</th> 
                 <th>Vehicle</th> 
                 <th class="<?php echo $hidecolumn;?>">Opening Km</th> 
                 
                 <th class="<?php echo $hidecolumn;?>">Closing Km</th> 
                 <th class="<?php echo $hidecolumn;?>">Km Difference</th> 
                  <th>Opening Hour</th>
                 <th>Closing Hour</th>
                 <th>Hour Difference</th>
                
                </tr>
                </thead>
                <tbody>
                
                  <?php 
					// echo "<pre>";
					// print_r($tripReport);
					// echo "</pre>";
					
              		$i = 1;
                  $row=0;
              		foreach ($vehicleData as $value) {                      
                                           
              		?>

					<tr>
						<td><?php echo $i; ?>
              
            </td> 
            <td style="font-weight: bold;color: #dd7020;"><?php echo $value->equipment_name; ?></td>

            <td class="<?php echo $hidecolumn;?>">
            <input type="hidden" name="distance_details_id[]" id="distance_details_id_<?php echo $row;?>" 
            value="<?php if($mode=="EDIT"){echo $value->distance_details_id;}else{echo '';}?>" readonly>
              <input type="hidden" name="equipment_id[]" id="equipment_id_<?php echo $row;?>" value="<?php echo $value->equipment_id; ?>" readonly>

              <input class="<?php echo $startinput?> startKM" type="text" name="start_km[]" id="start_km_<?php echo $row;?>" onKeyUp="numericFilter(this);" autocomplete="off" value="<?php if($mode=="EDIT"){echo $value->start_km;}else{echo '';}?>" <?php echo $startinput?> >  </td>

               <td class="<?php echo $hidecolumn;?>">
                <input class="endKM" type="text" name="end_km[]" id="end_km_<?php echo $row;?>" onKeyUp="numericFilter(this);" autocomplete="off" value="<?php if($mode=="EDIT"){echo $value->end_km;}else{echo '';}?>">
              </td>

               <td class="<?php echo $hidecolumn;?>">
                 <input class="readonly" type="text" name="km_differ[]" id="km_differ_<?php echo $row;?>" value="<?php if($mode=="EDIT"){echo $value->km_differ;}else{echo '';}?>" readonly >
               </td>

            <td><input class="startHour" type="text"  name="start_hour[]" id="start_hour_<?php echo $row;?>" autocomplete="off"  value="<?php if($mode=="EDIT"){echo $value->start_time;}else{echo '';}?>" onKeyUp="numericFilter(this);" readonly >
                &nbsp;<!-- <i class="glyphicon glyphicon-remove-circle reset"  onclick="return resetInput('start_hour_',<?php echo $row;?>)"></i> -->

              <!--  <input type="text" class=" timepicker" id="end_time" name="end_time" placeholder="End Time" autocomplete="off" value="" > -->


            </td>
           
            <td><input class="endHour" type="text"  name="end_hour[]" id="end_hour_<?php echo $row;?>" autocomplete="off"  value="<?php if($mode=="EDIT"){echo $value->end_time;}else{echo '';}?>" onKeyUp="numericFilter(this);">
              &nbsp;<!-- <i class="glyphicon glyphicon-remove-circle reset"  onclick="return resetInput('end_hour_',<?php echo $row;?>)"></i> -->
            </td>

              <td>
                 <input class="readonly diffTime" type="text" name="time_differ[]" id="time_differ_<?php echo $row;?>" value="<?php if($mode=="EDIT"){echo $value->time_differ;}else{echo '';}?>" readonly >
              </td>
           
                       
				    </tr>              			
              	<?php
                    $i++;$row++;
              		}
              	?>
                </tbody>
               
              </table>

                  <p id="error_msg_distance" class="form_error"></p>
                  <p id="response_message" ></p>

                  <div class="btnDiv">
                      <button type="submit" class="btn btn-primary formBtn" id="distancesavebtn"><?php echo $btnText; ?></button>
                    
                      <span class="btn btn-primary formBtn loaderbtn" id="loaderbtn" style="display:none;"><i class="fa fa-spinner rotating" aria-hidden="true"></i> <?php echo $btnTextLoader; ?></span>
                  </div>

            </form>


</div>