<script type="text/javascript">
$(function(){
	var card_row = $('tr.card:last').clone();
	$('#add_card').click(function(){
		card_row.clone().appendTo('#card_table');
		return false;
	});
});	
</script>
<?php echo ri('Search for customer');?><br />

    <form action="<?php $router->generate('admin_card_sell_order')?>" method="GET">
    <fieldset>
    	<legend><?php echo ri('Customer')?></legend>
        <label for="customers_email"><?php echo ri('Customer email')?></label>
        <?php echo zen_draw_input_field('customers_email', '', 'id="customers_email"');?>
        
        <label for="customers_firstname"><?php echo ri('Customer firstname')?></label>
        <?php echo zen_draw_input_field('customers_firstname', '', 'id="customers_firstname"');?>
        
        <label for="customers_lastname"><?php echo ri('Customer lastname')?></label>
        <?php echo zen_draw_input_field('customers_lastname', '', 'id="customers_lastname"');?>
        
        <label for="customers_id"><?php echo ri('Customer id')?></label>
        <?php echo zen_draw_input_field('customers_id', '', 'id="customers_id"');?>
    </fieldset>
    
    <fieldset>
    	<legend><?php echo ri('Card')?></legend>
    	<label for="number_of_card"><?php echo ri('Number of card')?></label>
        <?php echo zen_draw_input_field('number_of_card', '10', 'id="number_of_card"');?>
    </fieldset>
    <button type="submit"><?php echo ri('Search')?></button>
</form>
<?php if($customer !== false):?>

<h4><?php echo ri('Customer')?></h4>

<?php echo $customer->customersFirstname . ' ' . $customer->customersLastname ?> (<?php echo $customer->customersEmailAddress?>)

<h3>Order details</h3>

<?php if (isset($order)) :?>
	<?php echo sprintf(ri('<a href="%s">New order</a> created'), $router->generate('admin_card_sell', array('pay_method' => 'sell', 'action' => 'view', 'card_orders_id' => $order->id)))?>
<?php endif?>

<form action="<?php echo $router->generate('admin_card_sell_order', riGetAllGetParams())?>" method="POST">
<table>		
	<tr>
		<td>Customer name:
		</td>
		<td>
		    <?php echo zen_draw_input_field('info[name]', $customer->customersFirstname . ' ' . $customer->customersLastname)?>
		    <?php echo zen_draw_hidden_field('info[customers_id]', $customer->customersId); ?>
		</td>		
	</tr>
		
	<tr>
		<td>Address
		</td>
		<td><?php echo zen_draw_input_field('info[street_address]', $address->entryStreetAddress)?>
		</td>
	</tr>
	<tr>
		<td><?php echo ri('Address line 2')?>
		</td>
		<td><?php echo zen_draw_input_field('info[suburb]', $address->entrySuburb)?>
		</td>
	</tr>
	<tr>
		<td>City
		</td>
		<td><?php echo zen_draw_input_field('info[city]', $address->entryCity)?>
		</td>
	</tr>
	<tr>
		<td>State
		</td>
		<td><?php echo zen_draw_input_field('info[state]', $address->getZone()->zoneCode)?>
		</td>
	</tr>
	<tr>
		<td>Zip
		</td>
		<td><?php echo zen_draw_input_field('info[postcode]', $address->entryPostcode)?>
		</td>
	</tr>
	<tr>
		<td><?php rie('Country')?>
		</td>
		<td><?php echo zen_draw_input_field('info[country]', $address->getCountry()->countriesName);?>
		</td>
	</tr>
	<tr>
		<td>Phone
		</td>
		<td><?php echo zen_draw_input_field('info[phone]', $customer->customersTelephone)?>
		</td>
	</tr>
	
	<tr>
		<td>Customer Email
		</td>
		<td><?php echo $customer->customersEmailAddress;?>
		<?php echo zen_draw_hidden_field('info[email]', $customer->customersEmailAddress)?>
		</td>
	</tr>
	<tr>
		<td>Payment Type
		</td>
		<td><?php echo zen_draw_pull_down_menu('info[type]', $types_dropdown);?>
		</td>
	</tr>
	<tr>
		<td>SubPayment Type
		</td>		
		<td>
			<?php echo zen_draw_pull_down_menu('info[pay_type]', $payments_dropdown);?>			
		</td>
	</tr>	
	<tr>
		<td>Mass pay
		</td>		
		<td>
			<?php echo zen_draw_pull_down_menu('info[mass_pay]', array(array('text' => 'on', 'id' => 1), array('text' => 'off', 'id' => 0)), (int)$order->info['mass_pay']);?>			
		</td>
	</tr>	
		
	<tr>
		<td>Payment Email
		</td>
		<td><?php echo zen_draw_input_field('info[payment_email]', $customer->customersEmailAddress)?>
		</td>
	</tr>
	<tr>
		<td>Account #
		</td>
		<td><?php echo zen_draw_input_field('info[account_number]')?>
		</td>
	</tr>
	<tr>
		<td>Routing #
		</td>
		<td><?php echo zen_draw_input_field('info[routing_number]')?>
		</td>
	</tr>	
		
	<tr>
		</td>
		<td >Surcharge
		</td>
		<td><?php echo zen_draw_input_field('info[surcharge]', '', 'class="medium"')?>
		</td>
	</tr>
			
	<tr>
		</td>
		<td >Status
		</td>
		<td><?php echo zen_draw_pull_down_menu('info[card_orders_status]', $statuses_dropdown)?>
		</td>
	</tr>
	<tr>
		<td>Comment
		</td>		
		<td>
			<?php 			
							
			echo zen_draw_textarea_field('info[comment]', '', '65', '10');?>			
		</td>
	</tr>
	<tr>
		<td>Affiliate id
		</td>		
		<td>
			<?php 			
							
			echo zen_draw_input_field('info[affiliates_id]');?>			
		</td>
	</tr>					
</table>
<?php echo $riview->render('riMerchant::__merchants')?>
<script type="text/javascript">
<!--
jQuery(function() {	
	jQuery( ".merchants_names" ).bind( "autocompleteselect", function(event, ui) {
		jQuery(this).closest('tr').find('.buyback_percentage').val(ui.item.percent);
		return false;
	});
	
});

//-->
</script>
<h4>Card List</h4>
<table id="card_table">
	<tr class="dataTableHeadingRow">
		<th class="dataTableHeadingContent">Merchant</th>	
		<th class="dataTableHeadingContent">Face Value</th>	
		<th class="dataTableHeadingContent">Percent</th>
		<th class="dataTableHeadingContent">Custom Percent</th>		
		<th class="dataTableHeadingContent">Number</th>		
		<th class="dataTableHeadingContent">Pin</th>						
				
	</tr>

<?php 
	while ($number_of_card){
		?>
		<tr class="card">
			
			<td>
				<?php echo zen_draw_input_field('cards['.$number_of_card.'][merchants_name]', '', 'class="merchants_names"');?>
				<input type="hidden" name="cards[<?php echo $number_of_card?>][merchants_id]" class="merchants_ids" value=0 />
			</td>
			<td>
				<?php echo zen_draw_input_field('cards['.$number_of_card.'][face_value]', '', 'class="medium"')?>				
			</td>
			<td>
				<input class="buyback_percentage" disabled=true type="text" name="cards[<?php echo $number_of_card?>][default_percentage]" value="" /> 				
			</td>
			<td>
				<input class="buyback_percentage" type="text" name="cards[<?php echo $number_of_card?>][buyback_percentage]" value="" /> 				
			</td>
			<td>
				<?php echo zen_draw_input_field('cards['.$number_of_card.'][number]')?>				
			</td>		
			
			<td>
				<?php echo zen_draw_input_field('cards['.$number_of_card.'][pin]', '', 'class="small"')?>
			</td>		
				
		</tr>
		<?php 
		$number_of_card--;
	}
?>

</table>
<button id="add_card"><?php rie('Add card')?></button>
<input type="submit" name="submit" value="submit" /> 
</form>
<?php endif;?>