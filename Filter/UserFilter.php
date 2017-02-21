<?php

namespace Gisue\Filter;

use Gisue\System\Filter;

class UserFilter extends Filter
{
    public function list($passArray)
    {
        echo "UserFilter - isLogin<br>";
    }
    
    public function isAdmin($passArray)
    {
        echo "UserFilter - isAdmin<br>";
    }
}