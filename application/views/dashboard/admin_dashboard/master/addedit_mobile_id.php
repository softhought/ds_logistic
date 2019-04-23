<script src="<?php echo base_url(); ?>assets/js/adm_scripts/mobile.js"></script>  
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
        <li class="active">Mobile Id <?php echo $bodycontent['mode'];?></li>
    </ol>
</section>

 <!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary formBlock">
                <div class="box-header with-border">
                    <h3 class="box-title">Mobile Id</h3>
                    <a href="<?php echo base_url();?>master/mobile" class="link_tab"><span class="glyphicon glyphicon-list"></span></a>
                </div>
                <div class="box-body">  
                <p id="clsmsg" class="form_error"></p>                                
                    <form method="post" id="MobileForm">
                        <?php if ($bodycontent['mode']=="EDIT"){ 
                            echo '<input type="hidden" name="mobile_id" value="'.$bodycontent['editMobile']->mobile_id.'">';
                        }?>
                        <input type="hidden" name="mode" value="<?php echo $bodycontent['mode']; ?>">
                        <div id="mobile_uuid_div" class="form-group">
                            <label for="mobile_uuid">Mobile Id</label>
                            <input type="text" class="form-control desablecls" name="mobile_uuid" id="mobile_uuid" <?php if ($bodycontent['mode']=="EDIT"){ echo "value='".$bodycontent['editMobile']->mobile_uuid."'"; }?>  placeholder="Enter Mobile Unique Id" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="mobile_no">Mobile No</label>
                            <input type="text" class="form-control" name="mobile_no" id="mobile_no"  <?php if ($bodycontent['mode']=="EDIT"){ echo "value='".$bodycontent['editMobile']->mobile_no."'"; }?>  placeholder="Enter Mobile No" autocomplete="off">
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