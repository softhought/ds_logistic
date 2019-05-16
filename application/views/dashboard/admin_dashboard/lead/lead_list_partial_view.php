
    <table id="example" class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;">
                <thead>
                <tr>
                  <th style="width:5%;">Sl</th>
               
                  <th> Project</th>
                  <th>Date </th>
                  <th>Shift Code </th>
                  <th>Excavator </th>
                  <th>Carrying</th>
                  <th>Lead</th>
                  <th>RL In Face</th> 
                  <th>RL In Dump</th>
                   <th style="width:10%;">Action</th> 
                </tr>
                </thead>
                <tbody>
               
              	<?php 
				          
                      $i = 1;
                      foreach ($leadagvehiList as $value) {  
                     
                        
                       
              	?>

					          <tr>
						            <td><?php echo $i; ?></td>
                  
                         <td><?php echo $value->project_nickname; ?></td>  
                        <td><?php echo date("d-m-Y", strtotime($value->shift_date)); ?></td>                                              
                        <td><?php echo $value->shift_code; ?></td>                                              
                        <td><?php echo $value->equipment_name; ?></td>                                              
                        <td><?php echo $value->material; ?></td>                                              
                        <td><?php echo $value->lead; ?></td> 
                        <td><?php echo $value->rl_in_face; ?></td>                                             
                        <td><?php echo $value->rl_in_dump; ?></td>
                          <td>
                           <button type="button" class="btn btn-sm btn-danger editLeadAgnVehicle" 
                           data-toggle="modal" 
                           data-target="#LeadModal" 
                           data-leadagveid="<?php echo $value->id;?>"
                           data-mode ="EDITLEAD" 
                           data-project="<?php echo $value->project_nickname; ?>"
                           data-shiftdate="<?php echo date("d-m-Y", strtotime($value->shift_date)); ?>"
                           data-shiftcode="<?php echo $value->shift_code; ?>"
                           data-excavator="<?php echo $value->equipment_name; ?>"
                           data-carrying="<?php echo $value->material; ?>"
                           data-lead="<?php echo $value->lead; ?>"
                           data-rlinface="<?php echo $value->rl_in_face; ?>"
                           data-rlindump="<?php echo $value->rl_in_dump; ?>"
               ><i class="glyphicon glyphicon-edit"></i></button> 
                        </td>                                              
                       
                    </tr>              			
              	<?php
                    $i++;
              		}

              	?>
                </tbody>
               
              </table>