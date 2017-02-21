<?php

namespace Gisue\System;

class Object
{
    public $this_create_date;

    function __construct()
    {
        $this->this_create_date = date("Y-m-d H:i:s");
    }

    public function equals(Object $obj)
    {
        return strcmp($this->toString(), $obj->toString());
    }

    public function __toString()
    {
    	return $this->getArrayValue(get_object_vars($this), 'Class '.get_class($this));
    }
    
    public function getArrayValue($val, $var)
    {
    	$var .= '[';
    	foreach ($val as $key => $value) {
    		$var .= ' $'.$key.' => ';
    		if (is_object($value) || is_array($value)) {
    			$var .= $this->getArrayValue($value, $var);
    		} else {
    			$var .= $value;
    		}
    	}
    	return $var. ']';
    }
}