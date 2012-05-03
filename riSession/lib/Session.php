<?php

namespace plugins\riSession;
/*
 * A super sample session class
 */
class Session{
	public function set($key, $value){
		$_SESSION[$key] = $value;		
	}
	
	public function get($key, $default = null){
		return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
	}
	
	public function remove($key){
		unset($_SESSION[$key]);
	}
}