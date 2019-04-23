<script src="<?php echo base_url(); ?>assets/js/adm_scripts/supervisor.js"></script>  

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
        <li class="active">Employee List</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

		    <div class="box">
            <div class="box-header">
              <h3 class="box-title">Employee List</h3>&nbsp;
              <a href="<?php echo base_url();?>master/addSupervisor" class="link_tab"><span class="glyphicon glyphicon-plus"></span> ADD</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="datatalberes" style="overflow-x:hidden;">
              <table id="example" class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;">
                <thead>
                <tr>
                  <th style="width:5%;">Sl</th>
                  <th style="text-align:right;width:5%;">Action</th> 
                   <th>Emp Code</th>  
                   <th style="width:10%;">Name</th>     
                   <th style="width:10%;">Designation</th>     
                                 
                  <th>Pin</th>                  
                  <th>Project Code</th>                  
                  <th>Project</th>                  
                  <th>Status</th>                  
                                  
                </tr>
                </thead>
                <tbody>
               
              	<?php 
				          
                      $i = 1;
                       //pre($bodycontent['supervisorList']);
              		foreach ($bodycontent['supervisorList'] as $value) {   
                    
                    $status = "";
                    if($value->is_active=="Y")
                    {
                      $status = '<div class="status_dv "><span class="label label-success status_tag superstatus" data-setstatus="N" data-supervisorid="'.$value->supervisor_id.'" ><span class="glyphicon glyphicon-ok"></span> Active</span></div>';
                    }
                    else
                    {
                      $status = '<div class="status_dv"><span class="label label-danger status_tag superstatus" data-setstatus="Y" data-supervisorid="'.$value->supervisor_id.'"
                      ><span class="glyphicon glyphicon-remove"></span> Inactive</span></div>';
                    }
              		?>

					        <tr>
						            <td><?php echo $i; ?></td>
                        <td align="center"> 
							              <a href="<?php echo base_url(); ?>master/addSupervisor/<?php echo $value->supervisor_id; ?>" class="btn btn-primary btn-xs" data-title="Edit">
								              <span class="glyphicon glyphicon-pencil"></span>
							              </a>
						            </td>                                    
                        <td><?php echo $value->emp_code;?></td>    
                        <td><?php echo $value->name;?></td>    
                        <td style="font-weight: bold;"><?php 
                        if($value->designation=='OBSERVABLE'){echo "OBSERVER";}else{echo $value->designation;}
                        
                        ?></td>    
                        <td><?php echo $value->pin;?></td>
                        <td><?php echo $value->project_nickname;?></td>    
                        <td><?php echo $value->project_name;?></td>    
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