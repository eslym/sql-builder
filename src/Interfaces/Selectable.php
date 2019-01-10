<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10/1/2019
 * Time: 1:25 PM
 */

namespace Eslym\SqlBuilder\Dml\Interfaces;


use Eslym\SqlBuilder\Dml\Select;

interface Selectable
{
    /**
     * @param mixed ...$selects
     * @return Select
     */
    public function select(...$selects);
}