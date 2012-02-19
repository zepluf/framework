<?php echo ri('Please choose options to export');?><br />

<form action="<?php $router->generate('admin_card_sell_export')?>" method="POST">
<input type="hidden" name="action" value="export" />

<h2><?php echo ri('Export Filters:')?></h2>
<label for="date_from"><?php echo ri('Orders Placed From')?></label>
<?php echo zen_draw_input_field('date_from', '', 'class="datepicker" id="date_from"');?>
		
<label for="date_to"><?php echo ri('Orders Placed To')?></label>
<?php echo zen_draw_input_field('date_to', '', 'class="datepicker" id="date_to"');?>

<label for="date_completed_from"><?php echo ri('Orders Paid From')?></label>
<?php echo zen_draw_input_field('date_completed_from', '', 'class="datepicker" id="date_completed_from"');?>
		
<label for="date_completed_to"><?php echo ri('Orders Paid To')?></label>
<?php echo zen_draw_input_field('date_completed_to', '', 'class="datepicker" id="date_completed_to"');?>

<br /><br />

<label for="card_orders_status"><?php echo ri('Status')?></label>
<?php echo zen_draw_pull_down_menu('card_orders_status', $statuses_dropdown, 'id="card_orders_status"');?>

<label for="type"><?php echo ri('Type')?></label>
<?php echo zen_draw_pull_down_menu('type', $types_dropdown, 'id="type"');?>

<label for="pay_type"><?php echo ri('Payment Type')?></label>
<?php echo zen_draw_pull_down_menu('pay_type', $payments_dropdown, 'id="pay_type"'); ?>

<br />
<?php echo ri('note: if you select the default value for a filter, that filter will not be applied')?>
<hr />
<?php echo ri('Please choose the export type')?>
<select name='export_type'>
	<option value="payment">Export by Payment</option>
	<option value="order">Export by Order</option>
</select>

<label for="export_order_type"><?php echo ri('Options for exporting by order')?></label>
<?php echo zen_draw_pull_down_menu('export_order_type', array(array('text' => 'please choose (optional)', 'id' => ''), array('text' => 'detailed', 'id' => 'detailed'), array('text' => 'with affiliate', 'id' => 'affiliate')), '', 'id="export_order_type"'); ?>

<button type="submit"><?php echo ri('Export')?></button>
</form>