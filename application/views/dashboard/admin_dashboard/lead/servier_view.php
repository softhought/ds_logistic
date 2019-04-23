

   <select id="sel_servier" name="sel_servier" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
                            <option value="0">Select</option>
                              <?php 
                                if($servierList)
                                {
                                  foreach($servierList as $servierlist)
                                  { ?>
                                      <option value="<?php echo $servierlist->supervisor_id; ?>"  >
                                       <?php echo $servierlist->name; ?></option>
                                <?php   }
                                }
                              ?>
                          </select>