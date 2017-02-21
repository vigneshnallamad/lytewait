<?php 

namespace Gisue\Model;

use Gisue\System\Model;

class UserModel extends Model
{
	public function add()
	{
		echo 'Model also Working - ';
		echo $this->getName();
	}
}