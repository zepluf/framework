<?php
/**
 * Created by RubikIntegration Team.
 * Date: 9/26/12
 * Time: 2:12 PM
 * Question? Come to our website at http://rubikin.com
 */
// bof ri: ZePLUF
$content = ob_get_clean();
if(is_object($core_event)){
    $core_event->setContent($content);
    $container->get('dispatcher')->dispatch(plugins\riCore\Events::onPageEnd, $core_event);
    $content = $core_event->getContent();
}
if(!isset($print_content) || $print_content) echo $content;
// eof ri: cjloader
