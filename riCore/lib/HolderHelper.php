<?php
/**
 * Created by RubikIntegration Team.
 *
 * Date: 9/30/12
 * Time: 4:31 PM
 * Question? Come to our website at http://rubikin.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or refer to the LICENSE
 * file of ZePLUF
 */

namespace plugins\riCore;

use plugins\riPlugin\Plugin;
use Symfony\Component\Templating\Helper\Helper;

/**
 * core holder class
 */
class HolderHelper extends Helper{

    /**
     * holder array
     *
     * @var array
     */
    protected $holders = array();

    /**
     * dispatcher
     *
     * @var
     */
    protected $dispatcher;

    /**
     * container
     *
     * @var
     */
    protected $container;
    
    /**
     * returns the name of this helper
     * @return string
     */
    public function getName(){
        return 'holder';
    }
    
    /**
     * add content into holder
     * @param $holder is the holder name
     * @param $content is the content to be added into the holder
     * @param int $order is optional to sort the content inside this holder
     * @return HolderHelper
     */
    public function add($holder, $content, $order = 0){
        $this->holders[$holder][] = array('order' => $order, 'content' => $content);
        return $this;
    }

    /**
     * gets the content of the holder
     * @param $holder is the holder name
     * @return string
     */
    public function get($holder){
        $event = Plugin::get('templating.holder.event')->setHolder($holder);
        Plugin::get('dispatcher')->dispatch(HolderHelperEvents::onHolderStart, $event);
        Plugin::get('dispatcher')->dispatch(HolderHelperEvents::onHolderStart . '.' . $holder, $event);

        $content = '';
		if(isset($this->holders[$holder]) && count($this->holders[$holder])> 0){
			usort($this->holders[$holder], function($a, $b) {
				if ($a['order'] == $b['order']) {
	        		return 0;
				}
	    		return ($a['order'] < $b['order']) ? -1 : 1;
			});
			
			
			foreach ($this->holders[$holder] as $c)
				$content .= $c['content'];
		}
		
		Plugin::get('dispatcher')->dispatch(HolderHelperEvents::onHolderEnd, $event);
        Plugin::get('dispatcher')->dispatch(HolderHelperEvents::onHolderEnd . '.' .$holder, $event);

        $this->holders[$holder] = array();

		return $content;
    }

    /**
     * parse the content, find all holders, and then inject content of each holder
     * @param $content
     * @return mixed
     */
    public function injectHolders($content){
        // we want to loop through all the registered holders
        // scan the content to find holders
		preg_match_all("/(<!-- holder:)(.*?)(-->)/", $content, $matches, PREG_SET_ORDER);
		foreach ($matches as $val) {
            $inject_content = $this->get(trim($val[2]));
            // now we need to inject into inject content *_*
            $inject_content = $this->injectHolders($inject_content);
			$content = str_replace($val[0], $inject_content . "<!-- holder:" . $val[2] . "-->", $content);
		}

        return $content;
    }
}