<script src="<?php echo base_url(); ?>assets/js/adm_scripts/assignMobiletoVehicle.js"></script>  
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
        <li class="active">Assign Mobile to Vehicle <?php echo $bodycontent['mode'];?></li>
    </ol>
</section>

 <!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary formBlock">
                <div class="box-header with-border">
                    <h3 class="box-title">Assign Mobile to Vehicle</h3>
                    <a href="<?php echo base_url();?>master/assignMobiletoVehicleList" class="link_tab"><span class="glyphicon glyphicon-list"></span></a>
                </div>
                <div class="box-body">  
                <p id="clsmsg" class="form_error"></p>                                
                    <form method="post" id="assignMobiletoVehicle">                       
                        <input type="hidden" name="mode" value="<?php echo $bodycontent['mode']; ?>">
                        <div class="form-group">
                            <label for="mobile_id">Mobile*</label>
                            <div id="mobile_id_dropdown">
                                <select id="mobile_id" name="mobile_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
                                    <option value="0">Select</option> 
                                    <?php 
                                        if($bodycontent['MobileList'])
                                        {
                                            foreach($bodycontent['MobileList'] as $mobile)
                                            { 
                                    ?>
                                                <option value="<?php echo $mobile->mobile_id; ?>" <?php if(($bodycontent['mode']=="EDIT") && $bodycontent['EditMobileAssign']->mobile_uniq_id==$mobile->mobile_id){echo "selected";}else{echo "";} ?> ><?php echo $mobile->mobile_uuid." (".$mobile->mobile_no.")"; ?></option>
                                    <?php   }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="vehicle_id">Vehicle*</label>
                            <div id="vehicle_id_dropdown">
                                <select id="vehicle_id" name="vehicle_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
                                    <option value="0">Select</option> 
                                    <?php 
                                        if($bodycontent['VehicleList'])
                                        {
                                            foreach($bodycontent['VehicleList'] as $vehicle)
                                            { 
                                    ?>
                                                <option value="<?php echo $vehicle->vehicle_id; ?>" <?php if(($bodycontent['mode']=="EDIT") && $bodycontent['EditMobileAssign']->vehicle_id==$vehicle->vehicle_id){echo "selected";}else{echo "";} ?> ><?php echo $vehicle->equipment_name; ?></option>
                                    <?php   }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="btnDiv">
                            <button type="submit"  name="submit" id="cassavebtn" class="btn formBtn btn-primary"><?php echo $bodycontent['btnText'];?></button>
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