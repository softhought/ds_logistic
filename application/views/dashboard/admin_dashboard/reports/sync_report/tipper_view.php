

<select id="sel_tipper" name="sel_tipper" class="form-control selectpicker" class="form-control selectpicker"
                       data-show-subtext="true" data-actions-box="true" data-live-search="true"  >
                        <option value="0">Select</option> 
	
		<?php
				foreach ($tipperList as $key => $value) { ?>

				<option value="<?php echo $value->equipment_id; ?>"><?php echo $value->equipment_name; ?></option>

					<?php	}
					?>

</select>