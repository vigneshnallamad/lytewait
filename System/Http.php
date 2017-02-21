<?php
namespace Gisue\System;

class Http extends Object
{
    public $req;
    public $res;
    public $class;
    public $function;
    public $actionPos;

    function __construct()
    {
    	parent::__construct();
        $this->req = new Request();
        $this->res = new Response();
    }
    
    public function setUrlParsingPosition($class)
    {
    	$classes = explode("-",$this->req->urlParts[$class]);
    	$this->actionPos = $class + 1; 
    	$functions = explode("-",$this->req->urlParts[$this->actionPos]);
    	
    	if (is_array($classes)) {
    		$class = '';
    		foreach ($classes as $part)
    			$class .= ucfirst($part);
    		$this->class = $class;
    	} else {
    		$this->class = $this->req->urlParts[$class];
    	}
    	
    	if (is_array($functions)) {
    		$function = $functions[0];
    		unset($functions[0]);
    		foreach ($functions as $part)
    			$function .= ucfirst($part);
    		$this->function = $function;
    	} else {
    		$this->function = $this->req->urlParts[$function];
    	}
    }
}