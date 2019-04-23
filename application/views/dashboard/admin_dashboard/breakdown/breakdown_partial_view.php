

    <table id="example" class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;">
                <thead>
                <tr>
                  <th style="width:5%;">Sl</th>
               
                  <th>Date </th>
                  <th>Vehicle No </th>
                  <th>Driver </th>
                  <th>Mobile </th>
                  <th>Mobile UID </th>
                  <th style="width:10%;">Action</th> 
                
               
                </tr>
                </thead>
                <tbody>
               
              	<?php 
				          
                      $i = 1;
                      foreach ($breakDownList as $value) {  

                     if($value->is_approved=="Y")
                    {
                      $status = '<div class="status_brk "><span class="label label-success status_tag breakdownstatus" data-setstatus="N" data-breakdownid="'.$value->breakdown_id.'"> Approved</span></div>';
                    }
                    else
                    {
                      $status = '<div class="status_brk"><span class="label label-danger status_tag breakdownstatus" data-setstatus="Y" 
                      data-breakdownid="'.$value->breakdown_id.'"> Not Approve</span></div>';
                    }
                     
                        
                       
              	?>

					          <tr>
						            <td><?php echo $i; ?></td>
                    <!--    <td>
                          <a href="<?php echo base_url(); ?>project/addProject/<?php echo $value->project_id; ?>" class="btn btn-primary btn-xs" data-title="Edit">
                            <span class="glyphicon glyphicon-pencil"></span>
                          </a>
                        </td> -->
                        <td><?php echo date("d-m-Y",strtotime($value->breakdown_date)); ?></td>                                              
                        <td><?php echo $value->equipment_name; ?></td>                                              
                        <td><?php echo $value->driver_name; ?></td>                                              
                        <td><?php echo $value->mobile_no; ?></td>                                              
                        <td><?php echo $value->mobile_uuid; ?></td>   
                        <td>
                          <a href="<?php echo base_url(); ?>breakdown/addBreakdown/<?php echo $value->breakdown_id; ?>" class="btn btn-success btn-xs" data-title="Edit">
                              <span class=" glyphicon glyphicon-arrow-right "></span>
                            </a>
                        </td>                                           
                                                             
                       
                    </tr>              			
              	<?php
                    $i++;
              		}

              	?>
                </tbody>
               
              </table>