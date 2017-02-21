<?php 

namespace Gisue\Controller;

use Gisue\System\Controller;

class UserController extends Controller
{
	public function listing($arr1, $id, $str, $arr2)
	{
		echo 'arr1 = ' . $arr1;
		echo ' | id = ' . $id;
		echo ' | str = ' . $str;
		echo ' | arr2 = ' . $arr2;
		$modelName = $this->getModelName();
		$modelObj = new $modelName($this->app);
		echo $modelObj->add();
		echo "<br>UserController - listAction working boss";
	}
}