
    <table id="example" class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;">
                <thead>
                <tr>
                  <th style="width:5%;">Sl</th>
                <!--   <th style="width:10%;">Action</th> -->
                  <th> Project</th>
                  <th>Date </th>
                  <th>Shift Code </th>
                  <th>Excavator </th>
                  <th>Carrying</th>
                  <th>Lead</th>
                  <th>RL In Face</th> 
                  <th>RL In Dump</th> 
                </tr>
                </thead>
                <tbody>
               
              	<?php 
				          
                      $i = 1;
                      foreach ($leadagvehiList as $value) {  
                     
                        
                       
              	?>

					          <tr>
						            <td><?php echo $i; ?></td>
                    <!--    <td>
                          <a href="<?php echo base_url(); ?>project/addProject/<?php echo $value->project_id; ?>" class="btn btn-primary btn-xs" data-title="Edit">
                            <span class="glyphicon glyphicon-pencil"></span>
                          </a>
                        </td> -->
                         <td><?php echo $value->project_nickname; ?></td>  
                        <td><?php echo date("d-m-Y", strtotime($value->shift_date)); ?></td>                                              
                        <td><?php echo $value->shift_code; ?></td>                                              
                        <td><?php echo $value->equipment_name; ?></td>                                              
                        <td><?php echo $value->material; ?></td>                                              
                        <td><?php echo $value->lead; ?></td> 
                        <td><?php echo $value->rl_in_face; ?></td>                                             
                        <td><?php echo $value->rl_in_dump; ?></td>                                             
                       
                    </tr>              			
              	<?php
                    $i++;
              		}

              	?>
                </tbody>
               
              </table>