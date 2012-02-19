<h3>Order details</h3>
<form action="<?php echo $router->generate('admin_card_sell', riGetAllGetParams())?>" method="POST">
<input type="hidden" name="sub_action" value="update" />
<table>
	<tr>
		</td>
		<td >id
		</td>
		<td><?php echo $order->id?>
		</td>
	</tr>
	<tr>
		</td>
		<td >Status
		</td>
		<td><?php echo zen_draw_pull_down_menu('info[card_orders_status]', $statuses_dropdown, $order->info['card_orders_status'])?>
		</td>
	</tr>
	<tr>
		<td>Customer name:
		</td>
		<td><?php echo zen_draw_input_field('info[name]', $order->info['name'])?>
		</td>		
	</tr>
		
	<tr>
		<td>Address
		</td>
		<td><?php echo zen_draw_input_field('info[street_address]', $order->info['street_address'])?>
		</td>
	</tr>
	<tr>
		<td><?php echo ri('Address line 2')?>
		</td>
		<td><?php echo zen_draw_input_field('info[suburb]', $order->info['suburb'])?>
		</td>
	</tr>
	<tr>
		<td>City
		</td>
		<td><?php echo zen_draw_input_field('info[city]', $order->info['city'])?>
		</td>
	</tr>
	<tr>
		<td>State
		</td>
		<td><?php echo zen_draw_input_field('info[state]', $order->info['state'])?>
		</td>
	</tr>
	<tr>
		<td>Zip
		</td>
		<td><?php echo zen_draw_input_field('info[postcode]', $order->info['postcode'])?>
		</td>
	</tr>
	<tr>
		<td><?php rie('Country')?>
		</td>
		<td><?php echo zen_draw_input_field('info[country]', $order->info['country'])?>
		</td>
	</tr>
	<tr>
		<td>Phone
		</td>
		<td><?php echo zen_draw_input_field('info[phone]', $order->info['phone'])?>
		</td>
	</tr>
	
	<tr>
		<td>Customer Email
		</td>
		<td><?php echo $customer->customersEmailAddress;?>
		</td>
	</tr>
		
	<?php if(!($order->info['pay_type'] == 2 || $order->info['pay_type'] == 3)) :?>
	<tr>
		<td>Payment Email
		</td>
		<td><?php echo zen_draw_input_field('info[payment_email]', $order->info['payment_email'])?>
		</td>
	</tr>
	<?php endif;?>
	<?php if($order->info['pay_type'] == 2) :?>
	<tr>
		<td>Account #
		</td>
		<td><?php echo zen_draw_input_field('info[account_number]', $order->info['account_number'])?>
		</td>
	</tr>
	<tr>
		<td>Routing #
		</td>
		<td><?php echo zen_draw_input_field('info[routing_number]', $order->info['routing_number'])?>
		</td>
	</tr>
	<?php endif;?>
	<tr>
		<td>Payment Type
		</td>
		<td><?php echo zen_draw_pull_down_menu('info[type]', $types_dropdown, $order->info['type']);?>
		</td>
	</tr>
	<tr>
		<td>SubPayment Type
		</td>		
		<td>
			<?php echo zen_draw_pull_down_menu('info[pay_type]', $payments_dropdown, $order->info['pay_type']);?>			
		</td>
	</tr>
	<tr>
		<td>Payment Date
		</td>		
		<td>
			<?php 
			$date_string = '';
			if(!empty($order->info['date_completed']) && $order->info['date_completed'] != '0000-00-00 00:00:00'){
				$date = new DateTime($order->info['date_completed']);
				$date_string = $date->format('Y-m-d');
			}			
							
			echo zen_draw_input_field('info[date_completed]', $date_string, 'class="datepicker"');?>			
		</td>
	</tr>
	<?php if($order->info['pay_type'] == 1): //show mass pay only for paypal option?>
	<tr>
		<td>Mass Pay
		</td>		
		<td>
			<?php 			
			echo zen_draw_pull_down_menu('info[mass_pay]', array(array('text' => 'on', 'id' => 1), array('text' => 'off', 'id' => 0)), (int)$order->info['mass_pay']);?>			
		</td>
	</tr>
	<?php endif;?>
	<tr>
		<td>Comment
		</td>		
		<td>
			<?php 			
							
			echo zen_draw_textarea_field('info[comment]', '', '65', '10', $order->info['comment']);?>			
		</td>
	</tr>
	<tr>
		<td>Affiliates Id
		</td>		
		<td>
			<?php 			
			echo zen_draw_input_field('info[affiliates_id]', $order->info['affiliates_id']);?>			
		</td>
	</tr>	
</table>

<h4>Card List</h4>
<table>
	<tr class="dataTableHeadingRow">
		<th class="dataTableHeadingContent">Merchant</th>	
		<th class="dataTableHeadingContent">Face Value</th>	
		<th class="dataTableHeadingContent">Percent</th>
		<th class="dataTableHeadingContent">
		
		<?php echo ($order->info['type'] == 2) ? 'Transaction Fee' : 'Payment'?>
		
		</th>
		<th class="dataTableHeadingContent">Number</th>		
		<th class="dataTableHeadingContent">Pin</th>						
		
		<th><input class="checkall" data-target="input.insert[type=checkbox]" type="checkbox"/>2product</th>
		<th><input class="checkall" data-target="input.delete[type=checkbox]" type="checkbox"/>delete</th>
	</tr>
<?php 
	foreach ($cards as $card){
		?>
		<tr>
			
			<td>
				<?php echo $card->merchant->name?>
			</td>
			<td>
				<?php echo zen_draw_input_field('cards['.$card->id.'][info][face_value]', $card->faceValue, 'class="medium"')?>				
			</td>
			<td>
				<input class="small" type="text" name="cards[<?php echo $card->id?>][info][buyback_percentage]" value="<?php echo $card->buybackPercentage;?>" /> 				
			</td>
			<td>
				<?php if($order->info['type'] == 2){
  		            echo $currencies->format($card->amazonFee);
        	        }
        	        else{
        	            if($order->info['pay_type'] == 1 && $order->info['mass_pay'] == 0)
        	                echo $currencies->format($card->paypalValue);
        	            else 
        	                echo $currencies->format($card->cashValue);
        	        }
        	    ?>				 		
			</td>
			<td>
				<?php echo zen_draw_input_field('cards['.$card->id.'][info][number]', $card->number)?>				
			</td>		
			
			<td>
				<?php echo zen_draw_input_field('cards['.$card->id.'][info][pin]', $card->pin, 'class="small"')?>
			</td>		
				
			<td>
				<input type="checkbox" class="insert" name="cards[<?php echo $card->id?>][insert]" value="1" />
			</td>			
			<td>
				<input type="checkbox" class="delete" name="cards[<?php echo $card->id?>][delete]" value="1" />
			</td>
		</tr>
		<?php 
		
	}
?>
	<tr>
				
		<td>Surcharge</td>	
		<td colspan="2"></td>	
		<td><?php echo zen_draw_input_field('info[surcharge]', $order->info['surcharge'], 'class="medium"')?></td>		
		<td colspan="4"></td>		
	</tr>
	<tr>
				
		<td>Total</td>		
		<td><?php echo $currencies->format($total['face_value']);?></td>
		<td></td>
		<td>
		<?php if($order->info['type'] == 2){
  		            echo $currencies->format($total['amazon_fee'] + $order->info['surcharge']);
	        }
	        else{
	            if($order->info['pay_type'] == 1 && $order->info['mass_pay'] == 0)
	                echo $currencies->format($total['paypal_value'] + $order->info['surcharge']);
	            else 
	                echo $currencies->format($total['cash_value'] + $order->info['surcharge']);
	        }
	    ?>         
		<td colspan="3"></td>
		
		<td></td>			
	</tr>
</table>
<button type="submit"><?php rie('Update')?></button> 
</form>