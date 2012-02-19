<?php echo $riview->render('riMerchant::__merchants')?>
<h3>Add new card</h3>
<form action="" method="post">
	<input type="hidden" name="sub_action" value="insert" />
	<table>
		<tr>
			<td>
				Merchant
			</td>
			<td>
				<?php echo zen_draw_input_field('merchants_name', '', 'id="merchants_name" class="merchants_names"');?>
				<input type="hidden" id="merchants_id" name="merchants_id" class="merchants_ids" value=0 />
			</td>
		</tr>
		<tr>
			<td>
				Face Value
			</td>
			<td>
				<?php echo zen_draw_input_field('face_value');?>
			</td>
		</tr>	
		<tr>				
			<td>
				Number
			</td>
			<td>
				<?php echo zen_draw_input_field('number');?>
			</td>
		</tr>
		<tr>	
			<td>
				Pin
			</td>
			<td>
				<?php echo zen_draw_input_field('pin');?>
			</td>
		</tr>
	</table>
	<button type="submit"><?php rie('Add Card')?></button>
</form>