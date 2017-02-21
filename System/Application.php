<?php
namespace Gisue\System;

class Application extends Object implements Constants
{
    public $http;
    public $collection;
    public $chain;
    public $namespace;

    function __construct()
    {
    	parent::__construct();
    }

    public function set($name,$func)
    {
    	if ($name == 'http') {
    		$this->http = $func();
    	} else if ($name == 'collection') {
    		$this->collection = $func();
    	} else if ($name == 'chain') {
    		$this->chain = $func();
    	} else if ($name == 'namespace') {
    		$this->namespace = $func();
    	} /* else { echo $name; echo $func(); } */
    }
        
    public function run()
    {
    	$this->chain->startRouting($this);
    }
    
    public function isClassExistsOrNot($namespace, $class, $fullPath = false)
    {
    	$files = [];
    	if (isset($this->{$namespace.'Files'})) {
    		$files = $this->{$namespace.'Files'};
    	} else {
    		if ($fullPath) {
    			$file = str_replace('\\', '/', $class);
    			$file = preg_replace('/^Gisue/', '../src', $file);
    			$tobeRomvedArr = explode('/', $file);
    			$class = $tobeRomvedArr[count($tobeRomvedArr) - 1];
    			$file = str_replace('/'.$class, '', $file);
    			$files = scandir($file);
    		} else {
	    		$file = str_replace('\\', '/', $this->namespace[$namespace]);
	    		$file = preg_replace('/^Gisue/', '../src', $file);
	    		$files = scandir($file);
    		}
    		$this->{$namespace.'Files'} = $files;
    	}
    	if ($fullPath) {
    		if (in_array($class.'.php', $files)) {
    			return true;
    		} else {
    			return false;
    		}
    	} else {
    		if (in_array($class.'.php', $files)) {
    			return true;
    		} else {
    			return false;
    		}
    	}
    }
    
    public function sendError($code, $error, $raw)
    {
    	$this->http->res->sendError($code, $error, $raw);
    }
}