<?php if(isset($discount)):?>
<form method="post" action="<?php echo $router->generate('admin_card_sell_discount', riGetAllGetParams())?>">
	<input type="hidden" name="sub_action" value="update" />
	<table>
		<tr>
			<td>
				<?php echo ri('Merchant name')?>
			</td>			
			<td>
    			<?php 
            	if($discount->merchantsId == 0)
            	    $merchant_name = ri('All Merchants');
            	else{
            	    $merchant_name = \plugins\riPlugin\Plugin::get('riMerchant.Merchants')->findById($discount->merchantsId)->name;
            	}
            	?>
    		    <?php echo $merchant_name;?>
    		</td>			
		</tr>
		
		<tr>
			<td>
				<?php echo ri('Discount Percentage')?>
			</td>			
			<td>				
				<?php echo zen_draw_input_field('discount_percentage', $discount->discountPercentage)?>
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