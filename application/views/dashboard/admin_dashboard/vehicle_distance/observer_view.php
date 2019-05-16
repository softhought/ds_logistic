

<select id="sel_observer" name="sel_observer" class="form-control selectpicker" class="form-control selectpicker"
                       data-show-subtext="true" data-actions-box="true" data-live-search="true"  >
                        <option value="0">Select</option> 
	
		<?php
				foreach ($observerData as $key => $value) { ?>

				<option value="<?php echo $value->supervisor_id; ?>"><?php echo $value->name; ?></option>

					<?php	}
					?>

</select>