<?php
/**
 * In case ZePLUF is installed and activated, this file will take the job of index.php
 * to process request(s) sent from client(s)
 *
 * Created by RubikIntegration Team.
 * Date: 9/2/12
 * Time: 10:06 AM
 * Question? Come to our website at http://rubikin.com
 */

/**
 * Always loads application_top
 */
require(__DIR__ . '/../includes/application_top.php');

// bof ri: ZePLUF

// set current page
$current_main_page = $_GET['main_page'];
if($current_main_page == 'index'){
    if(isset($_GET['cPath']))
        $current_main_page = 'category';
    elseif(isset($_GET['manufacturers_id']))
        $current_main_page = 'manufacturer';
}

use plugins\riPlugin\Plugin;
$zepluf_theme = Plugin::get('settings')->get('theme.is_zepluf_theme', false);
$core_event = Plugin::get('riCore.Event');
$container->get('dispatcher')->dispatch(plugins\riCore\Events::onPageStart, $core_event);
ob_start();
// eof ri: ZePLUF
$language_page_directory = DIR_WS_LANGUAGES . $_SESSION['language'] . '/';
$directory_array = $template->get_template_part($code_page_directory, '/^header_php/');
foreach ($directory_array as $value) {
    /**
     * We now load header code for a given page.
     * Page code is stored in includes/modules/pages/PAGE_NAME/directory
     * 'header_php.php' files in that directory are loaded now.
     */
    require($code_page_directory . '/' . $value);
}

/**
 * We now load the html_header.php file. This file contains code that would appear within the HTML <head></head> code
 * it is overridable on a template and page basis.
 * In that a custom template can define its own common/html_header.php file
 */
// bof ri: ZePLUF
// we will not load the html_header for ZePLUF theme here
if(!$zepluf_theme){
    require($template->get_template_dir('html_header.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/html_header.php');
}
// eof ri: ZePLUF
/**
 * Define Template Variables picked up from includes/main_template_vars.php unless a file exists in the
 * includes/pages/{page_name}/directory to overide. Allowing different pages to have different overall
 * templates.
 */
require($template->get_template_dir('main_template_vars.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/main_template_vars.php');
/**
 * Read the "on_load" scripts for the individual page, and from the site-wide template settings
 * NOTE: on_load_*.js files must contain just the raw code to be inserted in the <body> tag in the on_load="" parameter.
 * Looking in "/includes/modules/pages" for files named "on_load_*.js"
 */
$directory_array = $template->get_template_part(DIR_WS_MODULES . 'pages/' . $current_page_base, '/^on_load_/', '.js');
foreach ($directory_array as $value) {
    $onload_file = DIR_WS_MODULES . 'pages/' . $current_page_base . '/' . $value;
    $read_contents='';
    $lines = @file($onload_file);
    foreach($lines as $line) {
        $read_contents .= $line;
    }
    $za_onload_array[] = $read_contents;
}
/**
 * now read "includes/templates/TEMPLATE/jscript/on_load/on_load_*.js", which would be site-wide settings
 */
$directory_array=array();
$tpl_dir=$template->get_template_dir('.js', DIR_WS_TEMPLATE, 'jscript/on_load', 'jscript/on_load_');
$directory_array = $template->get_template_part($tpl_dir ,'/^on_load_/', '.js');
foreach ($directory_array as $value) {
    $onload_file = $tpl_dir . '/' . $value;
    $read_contents='';
    $lines = @file($onload_file);
    foreach($lines as $line) {
        $read_contents .= $line;
    }
    $za_onload_array[] = $read_contents;
}

// set $zc_first_field for backwards compatibility with previous version usage of this var
if (isset($zc_first_field) && $zc_first_field !='') $za_onload_array[] = $zc_first_field;

$zv_onload = "";
if (isset($za_onload_array) && count($za_onload_array)>0) $zv_onload=implode(';',$za_onload_array);

//ensure we have just one ';' between each, and at the end
$zv_onload = str_replace(';;',';',$zv_onload.';');

// ensure that a blank list is truly blank and thus ignored.
if (trim($zv_onload) == ';') $zv_onload='';
/**
 * Define the template that will govern the overall page layout, can be done on a page by page basis
 * or using a default template. The default template installed will be a standard 3 column layout. This
 * template also loads the page body code based on the variable $body_code.
 */

// bof ri: ZePLUF
// we need to load the layout here
if($zepluf_theme){
    $layout = Plugin::get('settings')->get('theme.layouts.' . $current_main_page, 'default.php');
    require($template->get_template_dir($layout,DIR_WS_TEMPLATE, $current_page_base,'layouts'). '/' . $layout);
}
else{
    require($template->get_template_dir('tpl_main_page.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_main_page.php');
    echo "</html>";
}
// eof ri: ZePLUF
?>

<?php
/**
 * Load general code run before page closes
 */
?>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>

<?php
// bof ri: ZePLUF
$content = ob_get_clean();
$core_event->setContent($content);
$container->get('dispatcher')->dispatch(plugins\riCore\Events::onPageEnd, $core_event);
echo $core_event->getContent();
// eof ri: ZePLUF
exit();