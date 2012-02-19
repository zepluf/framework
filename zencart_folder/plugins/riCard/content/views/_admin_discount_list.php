<?php if(isset($customer) && $customer !== false):?>
<div>

<?php echo $customer->customersFirstname . ' ' . $customer->customersLastname ?> (<?php echo $customer->customersEmailAddress?>)

</div>
<?php endif;?>

<?php if(isset($result_list)):?>
<form action="<?php echo $router->generate('admin_card_sell_discount', riGetAllGetParams());?>" method="POST">
<table>
	<tr class="dataTableHeadingRow">		
		<th class="dataTableHeadingContent"><?php echo ri('Merchants id');?></th>
		<th class="dataTableHeadingContent"><?php echo ri('Merchants name');?></th>
		<th class="dataTableHeadingContent"><?php echo ri('Standard discount');?></th>
		<th class="dataTableHeadingContent"><?php echo ri('Additional discount');?></th>
	</tr>
	<tr>		
		<td>N/A</td>
		<td>
		    All Merchants
		</td>				
		<td>N/A</td>
		<td>
		    <?php echo zen_draw_input_field('merchant[0][discount_percentage]', $all_merchant['discount_percentage'])?>
			<?php echo zen_draw_hidden_field('merchant[0][card_discounts_id]', $all_merchant['card_discounts_id'] ? $all_merchant['card_discounts_id'] : -1)?>
		</td>		
	</tr>
<?php 
	foreach($result_list->getResults() as $discount){ ?>	
	<tr>		
		<td><?php echo $discount->id;?></td>
		<td>
		    <?php echo $discount->name;?>
		</td>				
		<td><?php echo $discount->buybackPercentage;?></td>
		<td>
		    <?php echo zen_draw_input_field('merchant['.$discount->id.'][discount_percentage]', $discount->discountPercentage)?>
			<?php echo zen_draw_hidden_field('merchant['.$discount->id.'][card_discounts_id]', $discount->cardDiscountsId ? $discount->cardDiscountsId : -1)?>
		</td>		
	</tr>	
		
<?php }
?>
</table>  
<button type="submit"><?php echo ri('Mass update')?></button>
</form>
<?php echo $riview->render('riResultList::_pagination', array('current_page_base' => 'ri.php', 'result_list' => $result_list, 'current_route' => 'admin_card_sell_discount'));?>
<?php endif;?>