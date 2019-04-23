  <table id="example" class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;">
                <thead>
                <tr>
                  <th style="width:5%;">Sl</th>
               
                  <th>Date </th>
                  <th>Vehicle No </th>
                  <th>Driver </th>
                  <th>Mobile </th>
                  <th>Start Time </th>
                  <th>Resolve Date </th>
                  <th>Resolve Time </th>
                   <th>Breakdown Cause </th>
                  <th>Narration </th>
                  <th style="width:10%;">Status</th> 
                  <th style="width:10%;">Action</th> 
                
               
                </tr>
                </thead>
                <tbody>
               
                <?php 
                  
                      $i = 1;
                      foreach ($breakDownHistoryList as $value) {  


                     
                    
                
                      $status = '<div class="status_dv "><span class="label label-danger status_tag breakdownstatus" data-setstatus="N" data-breakdownid="'.$value->breakdown_id.'"><span class="glyphicon glyphicon-remove-circle"></span> Delete</span></div>';
                   
                   
                       
                ?>

                    <tr>
                        <td><?php echo $i; ?></td>
           
                        <td><?php echo date("d-m-Y",strtotime($value->breakdown_date)); ?></td>                                              
                        <td><?php echo $value->equipment_name; ?></td>                                              
                        <td><?php echo $value->driver_name; ?></td>                                              
                        <td><?php echo $value->mobile_no; ?></td>                                              
                        <td><?php echo date ('h:i A',strtotime($value->start_time));  ?></td>   
                        <td><?php echo date ('d-m-Y',strtotime($value->resolve_date));  ?></td>   
                        <td><?php echo date ('h:i A',strtotime($value->end_time)); ?></td>
                        <td><?php echo $value->cause; ?></td> 
                        <td><?php echo $value->narration; ?></td>   
                        <td style="font-weight: bold;color: green;">
                
                            <?php if($value->is_approved=="Y"){ echo "Resolved";}?>
                        </td>   
                        <td><?php echo $status; ?></td>                                         
                                                             
                       
                    </tr>                   
                <?php
                    $i++;
                  }

                ?>
                </tbody>
               
              </table>