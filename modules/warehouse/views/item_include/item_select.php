<?php if(isset($label_name)){ ?>
	<label><?php echo _l($label_name); ?>  </label>
<?php } ?>
<div class="form-group  select-placeholder">
	<select name="<?php echo html_entity_decode($select_name) ?>" class="selectpicker <?php if($ajaxItems == true){echo ' ajax-search';} ?>" data-width="100%" id="<?php echo html_entity_decode($id_name) ?>" <?php if(isset($multiple)){ ?> multiple="<?php echo html_entity_decode($multiple) ?>" <?php } ?> data-none-selected-text="<?php if(isset($data_none_selected_text)){echo _l($data_none_selected_text);} ?>" data-live-search="true" >
		<option value=""></option>
		<?php foreach($items as $group_id=>$_items){ ?>
			<option data-group-id="<?php echo $group_id; ?>" label="<?php echo $_items[0]['group_name']; ?>">
			<?php echo $_items[0]['group_name']; ?>
			</option>
		<?php } ?>
	</select>
</div>
