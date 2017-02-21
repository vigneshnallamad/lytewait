<?php

namespace Gisue\System;

class Filter extends Framework
{
	function __construct($app)
	{
    	parent::__construct($app);
		$this->className = 'filter';
	}
}