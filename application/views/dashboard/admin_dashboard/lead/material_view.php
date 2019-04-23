

                          <select id="material_type" name="material_type" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
                            <option value="0">Select</option>
                            <?php 
                                if($materialTypeList)
                                {
                                  foreach($materialTypeList as $materiallist)
                                  { ?>
                                      <option value="<?php echo $materiallist->project_material_id; ?>"  >
                                       <?php echo $materiallist->material; ?></option>
                                <?php   }
                                }
                              ?>
                           
                            
                          </select>