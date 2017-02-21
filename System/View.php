<?php 

namespace Gisue\System;

class View extends Framework
{
	function __construct($app)
	{
    	parent::__construct($app);
		$this->className = 'view';
	}
}