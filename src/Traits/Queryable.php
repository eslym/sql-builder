<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10/1/2019
 * Time: 4:22 PM
 */

namespace Eslym\SqlBuilder\Dml\Traits;


use Eslym\SqlBuilder\Dml\Expression;
use Eslym\SqlBuilder\Dml\SubQuery;

/**
 * Trait SubQueryable
 * @package Eslym\SqlBuilder\Dml\Traits
 * @mixin Expression
 */
trait Queryable
{
    /**
     * @param $var
     * @param null|string $alias
     * @return SubQuery
     */
    public function as(&$var, $alias = null){
        if($alias === null){
            $alias = 'query'.rand(1000, 9999);
        }
        return $var = $this->asName($alias);
    }

    /**
     * @param string $alias
     * @return SubQuery
     */
    public function asName(string $alias){
        return $this->getBuilder()->createExpression(SubQuery::class, $this, $alias);
    }
}