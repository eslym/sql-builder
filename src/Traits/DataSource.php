<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/1/2019
 * Time: 1:25 PM
 */

namespace Eslym\SqlBuilder\Dml\Traits;


use Eslym\SqlBuilder\Dml\Column;
use Eslym\SqlBuilder\Dml\Expression;

/**
 * Trait DataSource
 * @package Eslym\SqlBuilder\Dml\Traits
 *
 * @mixin Expression
 */
trait DataSource
{
    use Aliasable;

    /**
     * @param $name
     * @return Column
     */
    public function __get($name)
    {
        return $this->getBuilder()->createExpression(Column::class, $this, $name);
    }
}