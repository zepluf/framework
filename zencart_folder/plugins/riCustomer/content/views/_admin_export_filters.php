
<h2><?php echo ri('Report Filters:')?></h2>
<fieldset>
	<form action="<?php echo $router->generate('admin_customer_export');?>" method="POST">
	<input type="hidden" name="type" value="category" />
    <legend><?php echo ri('Export By Category:')?></legend>
    <label for="categories_id"><?php echo ri('Categories id')?></label>
    <?php echo zen_draw_input_field('filters[categories_id]', '', 'id="categories_id"');?>
    
    <label for="date_from"><?php echo ri('From')?></label>
    <?php echo zen_draw_input_field('filters[date_from]', '', 'class="datepicker" id="date_from"');?>
    		
    <label for="date_to"><?php echo ri('To')?></label>
    <?php echo zen_draw_input_field('filters[date_to]', '', 'class="datepicker" id="date_to"');?>
    <button type ="submit"><?php echo ri('Export')?></button>
    </form>
</fieldset>
	
<fieldset>
	<form action="<?php echo $router->generate('admin_customer_export');?>" method="POST">
    <legend><?php echo ri('Export Customers who never ordered:')?></legend>
    <input type="hidden" name="type" value="never" />
        
    <button type ="submit"><?php echo ri('Export')?></button>
    </form>
</fieldset>	

<fieldset>
	<form action="<?php echo $router->generate('admin_customer_export');?>" method="POST">
    <legend><?php echo ri('Export Last orders:')?></legend>
    <input type="hidden" name="type" value="last" />
    <label for="last_date_from"><?php echo ri('From')?></label>
    <?php echo zen_draw_input_field('filters[date_from]', '', 'class="datepicker" id="last_date_from"');?>
    		
    <label for="last_date_from"><?php echo ri('To')?></label>
    <?php echo zen_draw_input_field('filters[date_to]', '', 'class="datepicker" id="last_date_to"');?>    
    <button type ="submit"><?php echo ri('Export')?></button>
    </form>
</fieldset>	


<br class="clearfix"/>