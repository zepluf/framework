<?php

namespace Zepluf\Bundle\RiStoreBundle;

class Log extends Object{
	public function put($message, $session = false, $type = 'error', $scope = 'global'){
		$this->set('message', $message);
		$this->set('session', $session);
		$this->set('type', $type);
		$this->set('scope', $scope);
		return $this;
	}
}