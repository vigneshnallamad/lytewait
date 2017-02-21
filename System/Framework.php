<?php

namespace Gisue\System;

class Framework extends Object
{
	public $app;
	public $className;

	function __construct($app)
	{
    	parent::__construct();
		$this->app = $app;
	}
	
	public function __call($name, $arguments)
	{
		$this->app->sendError(400, 'Action not found in '.$this->className,
			[
				$this->className => get_class($this),
				"action" => $name
			]);
	}
	
	public static function __callStatic($name, $arguments)
	{
		(new Response())->sendError(400, 'Action not found in '.$this->className,
			[
				$this->className => get_called_class(),
				"action" => $name
			]);
	}
}