<?php

namespace plugins\riUtility;

class Uri{
    protected $uri = null;
    
    public function getCurrent() {
        if(!empty($this->uri)) return $this->uri;
        
        // for iis ISAPI Rewrite
        if (isset($_SERVER['HTTP_X_REWRITE_URL'])){
            $uri = $_SERVER['HTTP_X_REWRITE_URL'];
        }
        elseif (isset($_SERVER['REQUEST_URI'])) {
            $uri = $_SERVER['REQUEST_URI'];
        }
        else {
            if (isset($_SERVER['argv'])) {
                $uri = $_SERVER['SCRIPT_NAME'] .'?'. $_SERVER['argv'][0];
            }
            elseif (isset($_SERVER['QUERY_STRING'])) {
                $uri = $_SERVER['SCRIPT_NAME'] .'?'. $_SERVER['QUERY_STRING'];
            }
            else {
                $uri = $_SERVER['SCRIPT_NAME'];
            }
        }
        return $uri;
    }
}