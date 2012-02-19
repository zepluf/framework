<br />

<?php rie('Please make sure you upload a csv file that uses the EXACT same format with the csv generated from discounts export. 
Please note that the customer names and merchant names listed are just for display purpose.')?>

<br />

<form action="<?php echo $router->generate('admin_card_discount_import')?>" method="POST" enctype="multipart/form-data">
	<label for="file"><?php rie('File')?></label>
	<input type="file" name="file" />
	<button><?php rie('Submit')?></button>
</form>

 