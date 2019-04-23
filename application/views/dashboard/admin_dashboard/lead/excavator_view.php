

<select id="sel_excavator" name="sel_excavator" class="form-control selectpicker" class="form-control selectpicker"
                       data-show-subtext="true" data-actions-box="true" data-live-search="true"  >
                        <option value="0">Select</option> 
	
		<?php
				foreach ($excavatorList as $key => $value) { ?>

				<option value="<?php echo $value->vehicle_id; ?>"><?php echo $value->equipment_name; ?></option>

					<?php	}
					?>

</select>