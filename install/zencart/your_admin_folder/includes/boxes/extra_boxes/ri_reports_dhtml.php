<?php
if(plugins\riPlugin\Plugin::get('riZCAdmin.ZCAdmin'))
plugins\riPlugin\Plugin::get('riZCAdmin.ZCAdmin')->injectAdminMenu('reports', $za_contents);