<?php 
		
$current_page = $result_list->getPageNumber();
$total_page = $result_list->getNumberOfPages();

?>

<div style="clear:both"></div>
<ul class="pagination">

	<?php if($current_page - 5 > 1):?>
	<li class="page">
		<a href="<?php echo $router->generate($current_route, riGetAllGetParams(array('page'), array('page' => 1)));?>">1</a>
	</li>
		<?php if($current_page - 5 > 2):?>
		<li class="page">
			...
		</li>
		<?php endif;?>	
	<?php endif;?>	
	
	<?php for($page = $current_page - 5; $page < $current_page; $page++):?>
	<?php if($page > 0):?>
	<li class="page"><a
		href="<?php echo $router->generate($current_route, riGetAllGetParams(array('page'), array('page' => $page)));?>"><?php echo $page;?>
	</a>
	</li>
	<?php endif;?>
	<?php endfor;?>
	<li class="page current"><a
		href="<?php echo $router->generate($current_route, riGetAllGetParams(array('page'), array('page' => $current_page)));?>"><?php echo $current_page;?>
	</a>
	</li>
	<?php for($page = $current_page+1; $page < $current_page + 5 && $page <= $total_page; $page++):?>
	<li class="page"><a
		href="<?php echo $router->generate($current_route, riGetAllGetParams(array('page'), array('page' => $page)));?>"><?php echo $page;?>
	</a>
	</li>
	<?php endfor;?>

	<?php if($page < $total_page):?>
		<?php if($total_page - $current_page > 5):?>
		<li class="page">
			...
		</li>
		<?php endif;?>
	<li class="page">
	<a href="<?php echo $router->generate($current_route, riGetAllGetParams(array('page'), array('page' => $total_page)));?>"><?php echo $total_page;?></a>
	
	</li>
	<?php endif;?>
</ul>
<div style="clear:both"></div>
Displaying <?php echo $result_list->getNumberOfCurrentResults() ?> of <?php echo $result_list->getNumberOfResults(); ?> results