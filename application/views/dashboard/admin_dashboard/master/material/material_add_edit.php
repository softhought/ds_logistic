<script src="<?php echo base_url(); ?>assets/js/adm_scripts/material.js"></script>  

   <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Material <?php echo $bodycontent['mode']; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary formBlock">
              <div class="box-header with-border">
                <h3 class="box-title">Material </h3>
                 <a href="<?php echo base_url();?>material" class="link_tab"><span class="glyphicon glyphicon-list"></span> List</a>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
             
              <?php 
              $attr = array("id"=>"materialForm","name"=>"materialForm");
              echo form_open('',$attr); ?>
                <div class="box-body">
<p style="font-size: 12px;color: #971414;letter-spacing: 1px;text-align: center;font-weight: bold;">(Note:<?php echo IMPINFO;?> )</p>
                  <div class="row">
                  <div class="col-md-12">
                          <div class="form-group">
                            <label for="eqpname">Material</label>
                            <input type="text" class="form-control forminputs " id="material" name="material" placeholder="" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['materialEditdata']->material;}?>" >

                           
                          </div>

                           <div class="form-group">
                            <label for="eqpname">Unit</label>
                            <input type="text" class="form-control forminputs " id="unit" name="unit" placeholder="" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['materialEditdata']->unit;}?>" >

                           
                          </div>
                      </div><!-- end of col-md-12 -->

                      <div class="col-md-12">
                        <div class="form-group">
                          <input type="hidden" name="materialID" id="materialID" value="<?php echo $bodycontent['materialID']; ?>" />
                          <input type="hidden" name="mode" id="mode" value="<?php echo $bodycontent['mode']; ?>" />
                        
                        </div>
                      </div> <!-- end of col-md-12 -->
                   
                     
                     


                      
                     
                  </div>

                  <p id="error_msg" class="form_error"></p>

                  <div class="btnDiv">
                      <button type="submit" class="btn btn-primary formBtn" id="materialsavebtn"><?php echo $bodycontent['btnText']; ?></button>
                    
					            <span class="btn btn-primary formBtn loaderbtn" id="loaderbtn" style="display:none;"><i class="fa fa-spinner rotating" aria-hidden="true"></i> <?php echo $bodycontent['btnTextLoader']; ?></span>
                  </div>
                  
                </div>
                <!-- /.box-body -->

                <!-- <div class="box-footer">
                  <button type="submit" class="btn btn-primary">Save</button>
                </div> -->
              <?php echo form_close(); ?>

              <div class="response_msg" id="material_response_msg">
               
              </div>

            
            </div>
            <!-- /.box -->      
      </div>
    </div>

    </section>
    <!-- /.content -->