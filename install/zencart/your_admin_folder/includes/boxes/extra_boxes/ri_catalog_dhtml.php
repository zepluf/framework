<?php
if(plugins\riPlugin\Plugin::get('riZCAdmin.ZCAdmin'))
plugins\riPlugin\Plugin::get('riZCAdmin.ZCAdmin')->injectAdminMenu('catalog', $za_contents);