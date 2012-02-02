<?php 

function getBaseHref($admin = true){
	global $request_type;
	if($request_type == 'SSL')
		return HTTPS_SERVER . DIR_WS_HTTPS_ADMIN;
	else 
		return HTTP_SERVER . DIR_WS_ADMIN;
}

function ri($string){
	return $string;
}

function riAdminLink($route, $params, $file = 'ri.php'){
	return getBaseHref(true) . $file . $route . '?' . http_build_query($params, '', '&amp;');	
}

function riGetAllGetParams($exclude_array = array(), $new_params = array()) {
    global $_GET;

    if (!is_array($exclude_array)) $exclude_array = array($exclude_array);   

    $_get = $_GET;    
    if(!empty($exclude_array)){
	    foreach ($_get as $key => $value){
	    	if(in_array($key, $exclude_array))
	    		unset($_get[$key]);
	    }
    }
    
    if(is_array($new_params) && !empty($new_params))
    	$_get = array_merge($_get, $new_params);
    return $_get;
}