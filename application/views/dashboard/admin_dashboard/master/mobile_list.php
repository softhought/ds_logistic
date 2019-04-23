<script src="<?php echo base_url(); ?>assets/js/adm_scripts/mobile.js"></script>  

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
        <li class="active">Mobile List</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

		    <div class="box">
            <div class="box-header">
              <h3 class="box-title">Mobile List</h3>&nbsp;
              <a href="<?php echo base_url();?>master/setMobileId" class="link_tab"><span class="glyphicon glyphicon-plus"></span> ADD</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="datatalberes" style="overflow-x:hidden;">
              <table id="example" class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;">
                <thead>
                <tr>
                  <th style="width:10%;">Sl</th>
                  <th style="text-align:right;width:5%;">Action</th> 
                  <th style="width:20%;">Mobile Unique Id</th>     
                  <th>Mobile No</th>                  
                  <th>Status</th>                  
                                  
                </tr>
                </thead>
                <tbody>
               
              	<?php 
				          
                      $i = 1;
                    //   pre($bodycontent['mobileList']);
              		foreach ($bodycontent['mobileList'] as $value) {   
                    
                    $status = "";
                    if($value->is_active=="Y")
                    {
                      $status = '<div class="status_dv "><span class="label label-success status_tag mblstatus" data-setstatus="N" data-mobileid="'.$value->mobile_id.'"><span class="glyphicon glyphicon-ok"></span> Active</span></div>';
                    }
                    else
                    {
                      $status = '<div class="status_dv"><span class="label label-danger status_tag mblstatus" data-setstatus="Y" 
                      data-mobileid="'.$value->mobile_id.'"><span class="glyphicon glyphicon-remove"></span> Inactive</span></div>';
                    }
              		?>

					        <tr>
						            <td><?php echo $i; ?></td>
                        <td align="center"> 
							              <a href="<?php echo base_url(); ?>master/setMobileId/<?php echo $value->mobile_id; ?>" class="btn btn-primary btn-xs" data-title="Edit">
								              <span class="glyphicon glyphicon-pencil"></span>
							              </a>
						            </td>                                    
                        <td><?php echo $value->mobile_uuid; ?></td>                                     
                        <td><?php echo $value->mobile_no; ?></td>       
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