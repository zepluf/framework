<?php if(isset($customer)):?>

<?php echo $riview->render('riMerchant::__merchants')?>

<h3><?php echo ri('New Discount')?></h3>
<form method="post" action="<?php echo $router->generate('admin_card_sell_discount', riGetAllGetParams())?>">
	<input type="hidden" name="sub_action" value="insert" />
	<table>
		<tr>
			<td>
				<?php echo ri('Merchant name')?>
			</td>			
			<td>    			 
            	<?php echo zen_draw_input_field('merchants_name', '', 'id="merchants_name"');?>
            	<?php echo zen_draw_hidden_field('customers_id', $discount->customersId, 'id="customers_id"');?>				
    		</td>
    	</tr>
    	<tr>
    		<td>
				<?php echo ri('Merchant id')?>
			</td>			
			<td>    			 
            	<?php echo zen_draw_input_field('merchants_id', '', 'id="merchants_id"');?>				
    		</td>			
		</tr>
		
		<tr>
			<td>
				<?php echo ri('Discount Percentage')?>
			</td>			
			<td>				
				<?php echo zen_draw_input_field('discount_percentage')?>
			</td>
		</tr>
		
		<tr>
			<td colspan="2">
				<button type="submit"><?php echo ri('Submit')?></button>
			</td>
		</tr>
	</table>
</form>
<?php endif;?>