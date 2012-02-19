<script type="text/javascript">
<!--
$(function(){

	var dialog = $('#dialog').dialog({
		autoOpen: false,
		resizable: false,
		height:140,
		modal: true
	});
	
	$( ".dialog-confirm" ).click(function(e){
		e.preventDefault();

		var theHREF = $(this).attr("href");


		dialog.dialog('option', 'buttons', {
                "Yes" : function() {
                    window.location.href = theHREF;
                    },
                "No" : function() {
                    $(this).dialog("close");
                    }
                });

		dialog.dialog("open");
	});
})

//-->
</script>
<div id="dialog">Are you sure you want to delete the order?</div>
<table>
	<tr class="dataTableHeadingRow">
		<td class="dataTableHeadingContent">Id</td>
		<td class="dataTableHeadingContent">Date</td>
		<td class="dataTableHeadingContent">Customer</td>
		<td class="dataTableHeadingContent">Face Value</td>
		<td class="dataTableHeadingContent">
		<?php echo ($pay_method == 'trade') ? 'Transaction Fee' : 'Payment Amount'?>
		</td>
		<td class="dataTableHeadingContent">Status</td>
		<td class="dataTableHeadingContent">Payment Type</td>
		 
		<td class="dataTableHeadingContent">Action</td>                
	</tr>
	<?php 
	$totals = array('surcharge' => 0);
	foreach($result_list->getResults() as $order) {
  	$cards = $order->getCards()->getAll();
  	$total = $card_payment->calculateTotal($cards);
	
  	foreach($total as $key => $value){
  		if(!isset($totals[$key])) $totals[$key] = $value;
  		else 
  			$totals[$key] += $value;
  	}
  	
  	$totals['surcharge'] += $order->info['surcharge'];
  	?>
	<tr<?php if($card_orders_id == $order->id) echo " class='current'"?>>
		<td><?php echo $order->id; ?></td>
		<td><?php 
		$date = new DateTime($order->info['date_purchased']);
		echo $date->format('Y-m-d'); ?>
		</td>
  		<td><?php echo $order->info['name']; ?></td>
		<td><?php echo $currencies->format($order->info['face_value']); ?></td>
  		<td>
  		    <?php if($order->info['type'] == 2){
  		            echo $currencies->format($order->info['amazon_fee'] + $order->info['surcharge']);
  		        }
  		        else{
  		            if($order->info['pay_type'] == 1 && $order->info['mass_pay'] == 0)
  		                echo $currencies->format($order->info['paypal_value'] + $order->info['surcharge']);
  		            else 
  		                echo $currencies->format($order->info['cash_value'] + $order->info['surcharge']);
  		        }
  		    ?>  		       
		<td><?php echo $statuses[$order->info['card_orders_status']];?></td>
		<td>
		<?php
		
			
			if($order->info['type'] == 1){
				echo $payments[1]['payment_type'][$order->info['pay_type']]['name'];
			}else 
			echo $payments[$order->info['type']]['name'];					
		?>		
		</td>
  		
		<td> 
			<a href="<?php echo $router->generate('admin_card_sell', riGetAllGetParams(array('action', 'card_orders_id'), array('action' => 'view', 'card_orders_id' => $order->id)));?>">Edit</a> -
			<a class="dialog-confirm" href="<?php echo $router->generate('admin_card_sell', riGetAllGetParams(array('action', 'card_orders_id'), array('action' => 'delete', 'card_orders_id' => $order->id)));?>">Delete</a>
		</tr>
	<?php } 	
	?>
		<tr>
		<td colspan="9">
		<?php echo $riview->render('riResultList::_pagination', array('current_page_base' => 'ri.php', 'result_list' => $result_list));?>		
        
        </td>                            
	</tr>
</table>

<table>

<tr>
	
	<td><h3>Total Face Value</h3></td>
	<td><h4><?php echo $currencies->format($totals['face_value']);?></h4></td>
</tr>

<?php if($pay_method=="sell"):?>
<tr>
	
	<td><h3>Total Pay Amount</h3></td>
	<td><h4><?php echo $currencies->format($totals['cash_value'] - $totals['surcharge']); ?></h4></td>
</tr>
<?php else:?>
<tr>
	
	<td><h3>Total Transaction Amount</h3></td>
	<td><h4><?php echo $currencies->format($totals['amazon_fee'] + $totals['surcharge']); ?></h4></td>
</tr>
<?php endif;?>

</table>