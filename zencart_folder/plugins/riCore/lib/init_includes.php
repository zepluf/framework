<?php
if(IS_ADMIN_FLAG)
	$riview->addDefaultPathPattern('template', DIR_FS_ADMIN . 'includes/templates/template_default/');
else	
	$riview->addDefaultPathPattern('template', DIR_FS_CATALOG . DIR_WS_TEMPLATE);
