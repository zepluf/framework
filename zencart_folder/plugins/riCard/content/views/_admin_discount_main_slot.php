<?php echo ri('Search for discounts');?><br />
<?php echo $riview->render('riMerchant::__merchants')?>
<form action="<?php $router->generate('admin_card_sell_discount')?>" method="GET">

<label for="customers_email"><?php echo ri('Customer email')?></label>
<?php echo zen_draw_input_field('customers_email', '', 'id="customers_email"');?>

<label for="customers_firstname"><?php echo ri('Customer firstname')?></label>
<?php echo zen_draw_input_field('customers_firstname', '', 'id="customers_firstname"');?>

<label for="customers_lastname"><?php echo ri('Customer lastname')?></label>
<?php echo zen_draw_input_field('customers_lastname', '', 'id="customers_lastname"');?>

<label for="customers_id"><?php echo ri('Customer id')?></label>
<?php echo zen_draw_input_field('customers_id', '', 'id="customers_id"');?>

<br />
<label for="merchants_name"><?php echo ri('Merchant name')?></label>
<?php echo zen_draw_input_field('merchants_name', '', 'class="merchants_names" id="merchants_name"');?>

<label for="merchants_id"><?php echo ri('Merchant id')?></label>
<?php echo zen_draw_input_field('merchants_id', '', 'class="merchants_ids" id="merchants_id"');?>

<button type="submit"><?php echo ri('Search')?></button>
</form>
<br /><br />
<?php echo $riview->render('riCard::_admin_discount_list')?>