<script src="<?php echo base_url(); ?>assets/js/adm_scripts/breakdown.js"></script>  
<style>
#contralist td{
vertical-align: inherit;
}
</style>
   <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Breakdown History</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

		    <div class="box">
            <div class="box-header">
              <h3 class="box-title">Breakdown History</h3>&nbsp;
            
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
           <div class="col-md-4"></div>
                    

                        <div class="col-md-3" >
                        <div class="form-group">
                            <label></label>
                            <div class="input-group date" data-provide="datepicker" data-date-format="dd/mm/yyyy">
                                <input type="text" class="form-control" name="breakhistorydate" id="breakhistorydate" value="<?php echo date("d/m/Y"); ?>" readonly >
                                <div class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </div>
                            </div>
                            <!-- /.input group -->
                        </div>
                          <!--  <div id="loader" style="text-align:center;display:none;">
                  <img src="<?php echo base_url(); ?>assets/images/verify_logo.gif"  style="margin-left: auto;margin-right: auto;display: block;" /><br>
                  Please Wait Loading ...
              </div> -->
                  </div>   <!-- /.col-md-6 END -->

                </div>

              <div class="datatalberes" id="breakdownhistorylistdata" style="overflow-x:hidden;">
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
                      foreach ($bodycontent['breakDownHistoryList'] as $value) {  


                     
                    
                
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

              </div>


            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

    </section>
    <!-- /.content -->