<?php

namespace Zepluf\Bundle\StoreBundle;

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
				
			$log = new Log();
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
        if(!IS_ADMIN_FLAG){
            foreach ($messageStack->messages as $message){
                $this->add(array(
                    'message' => $message['text'],
                    'scope' => $message['class'],
                    'type' => $this->getZenMessageType($message['class'])
                ));
            }
        }
        else{
            foreach ($messageStack->errors as $message){
                $this->add(array(
                    'message' => $message['text'],
                    'scope' => 'global',
                    'type' => $this->getZenMessageType($message['params'])
                ));
            }
        }
    }

    private function getZenMessageType($class){
        $types = array(
            'messageStackError' => 'error',
            'messageStackWarning' => 'warning',
            'messageStackSuccess' => 'success',
            'messageStackCaution' => 'caution',
        );
        foreach ($types as $identified => $type){
            if(strpos($class, $identified) !== false)
                return $type;
        }
        return 'error';
    }

	public function getAsArray(){
	    $logs = array();
	    foreach($this->logs as $log)
	        $logs[] = $log->getArray();
	    return $logs;
	}
//
//    public function render(){
//        return Plugin::get('view')->render('riLog::_logs.php', array('logs' => $this->logs));
//    }

	public function clear(){
		$this->logs = array();
	}
}