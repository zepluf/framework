<form action="<?php echo $router->generate('admin_card_sell');?>" method="GET">
<h2><?php echo ri('Report Filters:')?></h2>
<fieldset>
<legend><?php echo ri('Time:')?></legend>
<label for="date_from"><?php echo ri('Orders Placed From')?></label>
<?php echo zen_draw_input_field('date_from', '', 'class="datepicker" id="date_from"');?>
		
<label for="date_to"><?php echo ri('Orders Placed To')?></label>
<?php echo zen_draw_input_field('date_to', '', 'class="datepicker" id="date_to"');?>

<label for="date_completed_from"><?php echo ri('Orders Paid From')?></label>
<?php echo zen_draw_input_field('date_completed_from', '', 'class="datepicker" id="date_completed_from"');?>
		
<label for="date_completed_to"><?php echo ri('Orders Paid To')?></label>
<?php echo zen_draw_input_field('date_completed_to', '', 'class="datepicker" id="date_completed_to"');?>


</fieldset>

<fieldset>
<legend><?php echo ri('Order:')?></legend>
<label for="customers_name"><?php echo ri('Customer name')?></label>
<?php echo zen_draw_input_field('customers_name', '', 'id="customers_name"');?>

<label for="card_orders_id"><?php echo ri('Order id')?></label>
<?php echo zen_draw_input_field('card_orders_id', '', 'id="card_orders_id"');?>

<label for="card_orders_status"><?php echo ri('Order status')?></label>
<?php echo zen_draw_pull_down_menu('card_orders_status', $statuses_dropdown, 'id="card_orders_status"');?>

</fieldset>	

<?php if($pay_method == 'sell'):?>
<fieldset>
<legend><?php echo ri('Payments:')?></legend>	

<label for="pay_type"><?php echo ri('Payment type')?></label>
<?php echo zen_draw_pull_down_menu('pay_type', $payments_dropdown, 'id="pay_type"');?>
</fieldset>
<?php endif;?>
	<input type="hidden" name="pay_method" value="<?php echo $pay_method?>" />
	<input type="hidden" name="action" value="default" />
	<input type="hidden" name="sub_action" value="filter" />
	<br class="clearfix"/>
	<input type="Submit" value="Submit" />
	<a href="<?php echo $router->generate('admin_card_sell', array('pay_method' => $pay_method));?>">Reset</a>
	
</form>
<br class="clearfix"/>