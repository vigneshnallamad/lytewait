<?php

namespace Gisue\System;

class Controller extends Framework
{
	function __construct($app)
	{
    	parent::__construct($app);
		$this->className = 'controller';
	}
	
	public function getModelName()
	{
    	return str_replace("Controller", "Model", get_class($this));
	}
}