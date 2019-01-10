<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10/1/2019
 * Time: 1:26 PM
 */

namespace Eslym\SqlBuilder\Dml\Traits;


use Eslym\SqlBuilder\Dml\Expression;
use Eslym\SqlBuilder\Dml\Select;

/**
 * Trait Selectable
 * @package Eslym\SqlBuilder\Dml\Traits
 *
 * @mixin Expression
 */
trait Selectable
{
    /**
     * @param mixed ...$selects
     * @return Select
     */
    public function select(...$selects){
        return $this->getBuilder()
            ->createExpression(Select::class)
            ->from($this)
            ->select(...$selects);
    }
}