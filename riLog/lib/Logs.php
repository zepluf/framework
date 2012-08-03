<?php

namespace plugins\riLog;

use plugins\riCore\Object;
use plugins\riPlugin\Plugin;

class Logs extends Object{
	
	private $logs = array();
	
	public function add($log){
		if(!$log instanceof Log){
			$args = array_merge(array(
				'message' => '', 
				'session' => false, 
				'type' => 'error', 
				'scope' => 'global'
				), $log);
				
			$log = Plugin::get('riLog.Log');
			$log->put($args['message'], $args['session'], $args['type'], $args['scope']);			
			
		}
		$this->logs[] = $log; 
	}
	
	
	function count(){
		return count($this->logs);	
	}
	
	public function copyToZen($admin = false){
		global $messageStack;
		
		foreach($this->logs as $log){
			if($log->session){
				if($admin)
					$messageStack->add_session($log->message, $log->type);
				else
					$messageStack->add_session($log->scope, $log->message, $log->type);
			}
			else{ 
				if($admin)
					$messageStack->add($log->message, $log->type);
				else
					$messageStack->add($log->scope, $log->message, $log->type);
			}					
		}	
		
		return $this;
	}

    public function copyFromZen(){
        global $messageStack;
        // $this->messages[] = array('params' => 'class="alert alert-error"', 'class' => $class, 'text' => zen_image($template->get_template_dir(ICON_IMAGE_ERROR, DIR_WS_TEMPLATE, $current_page_base,'images/icons'). '/' . ICON_IMAGE_ERROR, ICON_ERROR_ALT) . '  ' . $message);
        foreach ($messageStack->messages as $message){
            $this->add(array(
                'message' => $message['text'],
                'scope' => $message['class']
            ));
        }
    }

	public function getAsArray(){
	    $logs = array();
	    foreach($this->logs as $log)
	        $logs[] = $log->getArray();
	    return $logs;
	}
	
	public function clear(){
		$this->logs = array();
	}
}