<script src="<?php echo base_url(); ?>assets/js/adm_scripts/lead.js"></script>  
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
        <li class="active">Lead Against Vehicle List</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

		    <div class="box">
            <div class="box-header">
              <h3 class="box-title">Lead Against Vehicle List</h3>&nbsp;
              <a href="<?php echo base_url();?>lead/addLead" class="link_tab"><span class="glyphicon glyphicon-plus"></span> ADD</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
           <div class="col-md-4"></div>
                    

                        <div class="col-md-3" >
                        <div class="form-group">
                            <label></label>
                            <div class="input-group date" data-provide="datepicker" data-date-format="dd/mm/yyyy">
                                <input type="text" class="form-control" name="listshiftdate" id="listshiftdate" value="<?php echo date("d/m/Y"); ?>" readonly >
                                <div class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </div>
                            </div>
                            <!-- /.input group -->
                        </div>
                  </div>   <!-- /.col-md-6 END -->

                </div>

              <div class="datatalberes" id="leadlistdata" style="overflow-x:hidden;">
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
                      foreach ($bodycontent['leadagvehiList'] as $value) {  
                     
                        
                       
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

              </div>


            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

    </section>
    <!-- /.content -->