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
function ri($id, $parameters = array(), $domain = 'default', $locale = null){
	return plugins\riPlugin\Plugin::get('translator')->trans($id, (array)$parameters, $domain, $locale);
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
function rie($id, $parameters = array(), $domain = 'default', $locale = null){
    echo ri($id, $parameters, $domain, $locale);
}

function riLink($route, $params = array(), $request_type = 'NONSSL', $is_admin = null, $file = 'index.php'){

    // TODO: hook in seo url?
    if(is_null($is_admin)) $is_admin = defined('IS_ADMIN_FLAG') && IS_ADMIN_FLAG;

    $host = ($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER;

    $link = \plugins\riPlugin\Plugin::get('view')->get('router')->generate($route, $params);

    if(basename($_SERVER["SCRIPT_NAME"]) == 'ri.php')
        return $host . $link;

    if($is_admin){
        $file = 'ri.php';
        $host .= ($request_type == 'SSL') ? DIR_WS_HTTPS_ADMIN : DIR_WS_ADMIN;
    }
    else{
        //$file = 'index.php';
        $host .= ($request_type == 'SSL') ? DIR_WS_HTTPS_CATALOG : DIR_WS_CATALOG;
    }

    if($file == 'index.php'){
        $params['main_page'] = urlencode (trim($link, '/'));
        return $host . $file . '?' . http_build_query($params);
    }
    else
        return $host . $file . $link;
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

/**
 * If one of the Arguments isn't an Array, first Argument is returned.
 * If an Element is an Array in both Arrays, Arrays are merged recursively,
 * otherwise the element in $ins will overwrite the element in $arr (only if key is not numeric).
 * This also applys to Arrays in $arr, if the Element is scalar in $ins (in difference to the previous approach).
 * @param array $arr
 * @param array $ins
 * @return array
 */
function arrayMergeWithReplace($arr, $ins) {
    # Loop through all Elements in $ins:
    if (is_array($arr) && is_array($ins))
        foreach ($ins as $k => $v) {
            # Key exists in $arr and both Elemente are Arrays: Merge recursively.
            if (is_integer($k)){
                if (!in_array($v, $arr))
                    $arr[] = $v;
            }
            else if (isset($arr[$k]) && is_array($v) && is_array($arr[$k]))
                $arr[$k] = arrayMergeWithReplace($arr[$k], $v);
            # Place more Conditions here (see below)
            # ...
            # Otherwise replace Element in $arr with Element in $ins:
            else{
                $arr[$k] = $v;
            }
        }
    # Return merged Arrays:
    return($arr);
}

/**
 * http://stackoverflow.com/questions/3876435/recursive-array-diff
 * @param $array1
 * @param $array2
 * @return array
 */
function arrayRecursiveDiff($array1, $array2){
    $aReturn = array();

    foreach ($array1 as $mKey => $mValue) {
        if (is_array($array2) && array_key_exists($mKey, $array2)) {
            if (is_array($mValue)) {
                $aRecursiveDiff = arrayRecursiveDiff($mValue, $array2[$mKey]);
                if (count($aRecursiveDiff)) { $aReturn[$mKey] = $aRecursiveDiff; }
            } else {
                if ($mValue != $array2[$mKey]) {
                    $aReturn[$mKey] = $mValue;
                }
            }
        } else {
            $aReturn[$mKey] = $mValue;
        }
    }
    return $aReturn;
}

/**
 * Check if the array is an associative array.
 * Assuming even array start with index > 0 can still be the non associative array
 * @param $arr
 * @return bool
 */
function arrayIsAssoc($arr)
{
    foreach(array_keys($arr) as $key) if(!is_integer($key)) return true;
    return false;
}

/**
 * Check if the array is deeper than X level
 * @param $array
 * @param int $level
 * @return bool
 */
function arrayIsDeeper($array, $level = 1){
    $current_depth = 1;
    foreach($array as $value)
        if(is_array($value)) {
            $current_depth ++;
            if($current_depth > $level)
                return true;
            else return arrayIsDeeper($value, $level-1);
        }
    return false;
}

/**
 * Reindex a multi-dim array
 * @param $array
 */
function arrayRecursiveReindex(&$array){
    // if this is a
    if(!arrayIsAssoc($array)){
        $array = array_values($array);
    }

    if(arrayIsDeeper($array, 1)){
        foreach($array as $key => $value){
            if(is_array($value))
                arrayRecursiveReindex($array[$key]);
        }
    }
}

/**
 * @param $array
 * @param $value
 */
function arrayRemoveValue(&$array, $value){
    if(!is_array($array)) $array = array();
    else
        $array = array_values(array_diff($array, array($value)));
}

/**
 * @param $array
 * @param $value
 */
function arrayInsertValue(&$array, $value){
    if(!is_array($array)) $array = array($value);
    else
        if(!in_array($value, $array)) $array[] = $value;
}

/**
 * tries to generate new folders with given path
 * @param $absolute_path
 * @param int $chmod
 * @return bool
 */
function riMkDir($absolute_path, $chmod = 0777, $recursive = true){
    $success = false;
    if(!is_dir($absolute_path)){
        $old_umask = umask(0);
        $success = @mkdir($absolute_path, $chmod, $recursive);
        umask($old_umask);
    }
    return $success;
}