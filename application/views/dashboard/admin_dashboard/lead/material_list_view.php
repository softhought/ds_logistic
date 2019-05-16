
 
    <?php 
    $row=0;
                                
   if($materialTypeList)
         {
           foreach($materialTypeList as $materiallist)
              { ?>

                   <div class="row">

                      <div class="col-md-3">
                      <div class="form-group">
                          <label for="material_type">Carrying</label> 
                         <div id="material_dropdown">
                          <select id="material_type_<?php echo $row;?>" name="material_type_<?php echo $row;?>" class="form-control selectpicker"  >
                            <option value="<?php echo $materiallist->project_material_id; ?>"><?php echo $materiallist->material; ?></option>
                           
                          </select>
                        </div>

                        </div>
                      </div><!-- end of col-md-6 -->

                         <div class="col-md-2">
                          <div class="form-group">
                            <label for="lead">Lead</label>
                            <input type="text" class="form-control forminputs " id="lead_<?php echo $row;?>" name="lead_<?php echo $row;?>" placeholder="Lead" autocomplete="off" value="" >

                          
                          </div>
                      </div><!-- end of col-md-2 -->

                      <div class="col-md-2">
                        <div class="form-group">
                        
                          <label for="rl_in_face">RL In Face</label>
                          <input type="text" class="form-control forminputs" id="rl_in_face_<?php echo $row;?>" name="rl_in_face_<?php echo $row;?>" placeholder="RL In face" autocomplete="off" value=""   />


                        </div>
                      </div> <!-- end of col-md-2 -->

                          <div class="col-md-2">
                        <div class="form-group">
                        
                          <label for="rl_in_dump">RL In Dump</label>
                          <input type="text" class="form-control forminputs" id="rl_in_dump_<?php echo $row;?>" name="rl_in_dump_<?php echo $row;?>" placeholder="RL In Dump" autocomplete="off" value=""  />


                        </div>
                      </div> <!-- end of col-md-2 -->

                         <div class="col-md-3">
                         <div class="btnDiv" style="margin-top: 25px;">
                      <button type="submit" class="btn btn-primary leadsave" id="leadsavebtn_<?php echo $row;?>" style="width: 90px;">Save</button>
                      <button type="submit" class="btn btn-success leadsave" id="leadsavedcmp_<?php echo $row;?>" style="width: 90px;display: none;margin-left: 33px;"><i class="glyphicon glyphicon-ok"></i> Saved</button>
                    
                      <span class="btn btn-primary formBtn loaderbtn" id="loaderbtn_<?php echo $row;?>" style="display:none;"><i class="fa fa-spinner rotating" aria-hidden="true" style="width: 90px;"></i> Saveing..</span>
                  </div>
                      </div> <!-- end of col-md-2 -->


                  </div>
            





               
                 <?php   $row++;}
                   }

?>                           
                        
                            
                                          