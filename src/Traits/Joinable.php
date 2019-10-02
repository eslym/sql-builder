<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10/1/2019
 * Time: 12:57 PM
 */

namespace Eslym\SqlBuilder\Dml\Traits;

use Eslym\SqlBuilder\Dml\Expression;
use Eslym\SqlBuilder\Dml\Join;

/**
 * Trait Joinable
 * @package Eslym\SqlBuilder\Dml\Traits
 *
 * @mixin Expression
 */
trait Joinable
{
    /**
     * @param DataSource|Join|string $join
     * @param string $type
     * @return Join
     */
    public function join($join, $type = 'inner'){
        return $this->getBuilder()
            ->createExpression(Join::class, $this, $join, $type);
    }

    public function leftJoin($join){
        return $this->join($join, 'left');
    }

    public function rightJoin($join){
        return $this->join($join, 'right');
    }
}