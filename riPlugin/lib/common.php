<?php 

function getBaseHref($admin = true){
	global $request_type;
	if($request_type == 'SSL')
		return HTTPS_SERVER . DIR_WS_HTTPS_ADMIN;
	else 
		return HTTP_SERVER . DIR_WS_ADMIN;
}

/**
 * 
 * function used for translation
 * @param string $id
 * @param array $parameters
 * @param string $domain
 * @param string $locale
 * $return translated string
 */
function ri($id, array $parameters = array(), $domain = 'messages', $locale = null){
	return plugins\riPlugin\Plugin::get('translator')->trans($id, $parameters, 'messages', $locale);	
}

/**
 * 
 * function used for translation
 * @param string $id
 * @param array $parameters
 * @param string $domain
 * @param string $locale
 * $return void
 */
function rie($id, array $parameters = array(), $domain = 'messages', $locale = null){
    echo ri($id, $parameters, 'messages', $locale);
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

/**
 *    first variation
 *
 *    $input is input array
 *    $start is index of slice begin
 *    $end is index of slice end, if this is null, $replacement will be inserted (in the same way as original array_Slice())
 *indexes of $replacement are preserved in both examples
 */
function array_KSplice1(&$input, $start, $end=null, $replacement=null)
{
    $keys=array_Keys($input);
    $values=array_Values($input);
    if($replacement!==null)
    {
        $replacement=(array)$replacement;
        $rKeys=array_Keys($replacement);
        $rValues=array_Values($replacement);
    }

    $start=array_Search($start,$keys,true);
    if($start===false)
        return false;
    if($end!==null)
    {
        $end=array_Search($end,$keys,true);
        // if $end not found, exit
        if($end===false)
            return false;
        // if $end is before $start, exit
        if($end<$start)
            return false;
        // index to length
        $end-=$start-1;
    }

    // optional arguments
    if($replacement!==null)
    {
        array_Splice($keys,$start,$end,$rKeys);
        array_Splice($values,$start,$end,$rValues);
    }
    else
    {
        array_Splice($keys,$start,$end);
        array_Splice($values,$start,$end);
    }

    $input=array_Combine($keys,$values);

    return $input;
}

/**
 *    second variation
 *
 *    $input is input array
 *    $start is index of slice begin
 *    $length is length of slice, what will be replaced, if is zero, $replacement will be inserted (in the same way as original array_Slice())
 */
function array_KSplice2(&$input, $start, $length=0, $replacement=null)
{
    $keys=array_Keys($input);
    $values=array_Values($input);
    if($replacement!==null)
    {
        $replacement=(array)$replacement;
        $rKeys=array_Keys($replacement);
        $rValues=array_Values($replacement);
    }

    $start=array_Search($start,$keys,true);
    if($start===false)
        return false;

    // optional arguments
    if($replacement!==null)
    {
        array_Splice($keys,$start,$length,$rKeys);
        array_Splice($values,$start,$length,$rValues);
    }
    else
    {
        array_Splice($keys,$start,$length);
        array_Splice($values,$start,$length);
    }

    $input=array_Combine($keys,$values);

    return $input;
}