<script src="<?php echo base_url(); ?>assets/js/adm_scripts/supervisor.js"></script>  
<?php
    // pre($bodycontent['AccountList']);   
?>

<section class="content-header">
    <h1>
        Dashboard
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Employee <?php echo $bodycontent['mode'];?></li>
    </ol>
</section>

 <!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary formBlock">
                <div class="box-header with-border">
                    <h3 class="box-title">Employee</h3>
                    <a href="<?php echo base_url();?>master/supervisor" class="link_tab"><span class="glyphicon glyphicon-list"></span></a>
                </div>
                <div class="box-body">  
                <p style="font-size: 12px;color: #971414;letter-spacing: 1px;text-align: center;font-weight: bold;">(Note:<?php echo IMPINFO;?> )</p>
                <p id="clsmsg" class="form_error"></p>                                
                    <form method="post" id="SupervisorForm">
                         <input type="hidden" name="supervisorID" id="supervisorID" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['editSupervisor']->supervisor_id;}else{echo "0";}?>" />

                        <input type="hidden" name="mode" id="mode" value="<?php echo $bodycontent['mode']; ?>">

                        <div id="sel_employee_div" class="form-group">
                          <label for="sel_employee">Employee Type</label> 
                          <select id="sel_employee_type" name="sel_employee_type" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
                            <option value="0">Select</option>
                            <?php

                            $emp_type = array('SUPERVISOR', 'OBSERVABLE','SURVEYOR');
                        
                               

                            foreach ($emp_type as  $value) {
                            ?>
                              <option value="<?php echo $value;?>"
                              <?php if(($bodycontent['mode']=="EDIT") && $bodycontent['editSupervisor']->designation==$value){echo "selected";}else{echo "";}?>  
                                ><?php echo $value;?></option>
                             <?php }?>
                          </select>
                        </div>
                        <div id="supervisor_div" class="form-group">
                            <label for="supervisor_name">Name</label>
                            <input type="text" class="form-control desablecls" name="spname" id="spname" <?php if ($bodycontent['mode']=="EDIT"){ echo "value='".$bodycontent['editSupervisor']->name."'"; }?>  placeholder="Enter Name" autocomplete="off">
                        </div>

                        <div id="empcode_div" class="form-group">
                            <label for="employee_code">Employee Code</label>
                            <input type="hidden" id="preemp_code" name="preemp_code" placeholder="" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['editSupervisor']->emp_code;}?>" >
                            <input type="text" class="form-control" name="emp_code" id="emp_code"  <?php if ($bodycontent['mode']=="EDIT"){ echo "value='".$bodycontent['editSupervisor']->emp_code."'"; }?>  placeholder="Enter Employee Code" autocomplete="off">
                        </div>

                           <div id="pin_div" class="form-group">
                            <label for="supervisor_password">Pin</label>

                            <input type="text" class="form-control forminputs" id="supervisorpin" name="supervisorpin" placeholder="" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['editSupervisor']->pin;}?>" maxlength="4">

                            <input type="hidden" class="form-control forminputs" id="presupervisorpin" name="presupervisorpin" placeholder="" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['editSupervisor']->pin;}?>" maxlength="4">
                            
                            <p style="font-size: 12px;color: #9c9c9c;letter-spacing: 1px;">(Note:You can use alphanumeric pin )</p>

                        </div>

                        <div id="project_div" class="form-group">
                          <label for="project">Project</label> 
                          <select id="project" name="project" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
                            <option value="">Select</option>
                              <?php 
                                if($bodycontent['projectList'])
                                {
                                  foreach($bodycontent['projectList'] as $project)
                                  { ?>
                                      <option value="<?php echo $project->project_id; ?>" <?php if(($bodycontent['mode']=="EDIT") && $bodycontent['editSupervisor']->project_id==$project->project_id){echo "selected";}else{echo "";} ?> ><strong style="font-weight:700;">(<?php echo $project->project_nickname; ?>)</strong> <?php echo $project->project_name; ?></option>
                                <?php   }
                                }
                              ?>
                          </select>
                        </div>
                        <p id="error_msg" class="form_error"></p>
                        <div class="btnDiv">
                            <button type="submit"  name="submit" id="supervisorsavebtn" class="btn formBtn btn-primary"><?php echo $bodycontent['btnText'];?></button>
                            <span class="btn btn-primary formBtn loaderbtn" id="loaderbtn" style="display:none;"><i class="fa fa-spinner rotating" aria-hidden="true"></i> <?php echo $bodycontent['btnTextLoader']; ?></span>
                        </div>
                    </form>
                    <div class="response_msg" id="cas_response_msg">
                        <!-- response modal -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->