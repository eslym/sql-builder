<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/1/2019
 * Time: 4:32 PM
 */

namespace Eslym\SqlBuilder\Dml\Traits;


use Eslym\SqlBuilder\Dml\Expression;
use Eslym\SqlBuilder\Dml\Ignore;
use Eslym\SqlBuilder\Dml\Operate;
use Eslym\SqlBuilder\Dml\Parentheses;
use Eslym\SqlBuilder\Dml\SqlCase;

/**
 * Trait Operand
 * @package Eslym\SqlBuilder\Dml\Traits
 *
 * @mixin Expression
 */
trait Operand
{
    use Aliasable;

    /**
     * @param $expr
     * @return Operate
     */
    public function _add_($expr)
    {
        return $this->getBuilder()->createExpression(Operate::class, $this, '+', $expr);
    }

    /**
     * @param $expr
     * @return Operate
     */
    public function _sub_($expr)
    {
        return $this->getBuilder()->createExpression(Operate::class, $this, '-', $expr);
    }

    /**
     * @param $expr
     * @return Operate
     */
    public function _mul_($expr)
    {
        return $this->getBuilder()->createExpression(Operate::class, $this, '*', $expr);
    }

    /**
     * @param $expr
     * @return Operate
     */
    public function _div_($expr)
    {
        return $this->getBuilder()->createExpression(Operate::class, $this, '/', $expr);
    }

    /**
     * @param $expr
     * @return Operate
     */
    public function _mod_($expr)
    {
        return $this->getBuilder()->createExpression(Operate::class, $this, '%', $expr);
    }

    /**
     * @param $expr
     * @return Operate
     */
    public function _bitAnd_($expr)
    {
        return $this->getBuilder()->createExpression(Operate::class, $this, '&', $expr);
    }

    /**
     * @param $expr
     * @return Operate
     */
    public function _bitOr_($expr)
    {
        return $this->getBuilder()->createExpression(Operate::class, $this, '|', $expr);
    }

    /**
     * @param $expr
     * @return Operate
     */
    public function _bitXor_($expr)
    {
        return $this->getBuilder()->createExpression(Operate::class, $this, '^', $expr);
    }

    /**
     * @param $expr
     * @return Operate
     */
    public function _lShift_($expr)
    {
        return $this->getBuilder()->createExpression(Operate::class, $this, '<<', $expr);
    }

    /**
     * @param $expr
     * @return Operate
     */
    public function _rShift_($expr)
    {
        return $this->getBuilder()->createExpression(Operate::class, $this, '>>', $expr);
    }

    /**
     * @param $expr
     * @return Operate
     */
    public function _eql_($expr)
    {
        return $this->getBuilder()->createExpression(Operate::class, $this, '=', $expr);
    }

    /**
     * @param $expr
     * @return Operate
     */
    public function _equal_($expr)
    {
        return $this->getBuilder()->createExpression(Operate::class, $this, '<=>', $expr);
    }

    /**
     * @param $expr
     * @return Operate
     */
    public function _gt_($expr)
    {
        return $this->getBuilder()->createExpression(Operate::class, $this, '>', $expr);
    }

    /**
     * @param $expr
     * @return Operate
     */
    public function _lt_($expr)
    {
        return $this->getBuilder()->createExpression(Operate::class, $this, '<', $expr);
    }

    /**
     * @param $expr
     * @return Operate
     */
    public function _gtEq_($expr)
    {
        return $this->getBuilder()->createExpression(Operate::class, $this, '>=', $expr);
    }

    /**
     * @param $expr
     * @return Operate
     */
    public function _ltEq_($expr)
    {
        return $this->getBuilder()->createExpression(Operate::class, $this, '<=', $expr);
    }

    /**
     * @param $expr
     * @return Operate
     */
    public function _notEql_($expr)
    {
        return $this->getBuilder()->createExpression(Operate::class, $this, '<>', $expr);
    }

    /**
     * @param $case
     * @param $expr
     * @return SqlCase
     */
    public function _when_($case, $expr)
    {
        return $this->getBuilder()->createExpression(SqlCase::class, $this)->_when_($case, $expr);
    }

    /**
     * @param $expr
     * @return Operate
     */
    public function _like_($expr)
    {
        return $this->getBuilder()->createExpression(Operate::class, $this, 'LIKE', $expr);
    }

    /**
     * @param $expr
     * @return Operate
     */
    public function _is_($expr)
    {
        return $this->getBuilder()->createExpression(Operate::class, $this, 'IS', $expr);
    }

    /**
     * @param $expr
     * @return Operate
     */
    public function _in_($expr){
        return $this->getBuilder()->createExpression(Operate::class, $this, 'IN', $expr);
    }

    /**
     * @param $min
     * @param $max
     * @return Operate
     */
    public function _between_($min, $max)
    {
        $builder = $this->getBuilder();
        return $builder->createExpression(Operate::class, $this, 'BETWEEN', $min)->_and_($max);
    }

    /**
     * @param $expr
     * @return Operate
     */
    public function _or_($expr)
    {
        return $this->getBuilder()->createExpression(Operate::class, $this, 'OR', $expr);
    }

    /**
     * @param $expr
     * @return Operate
     */
    public function _and_($expr)
    {
        return $this->getBuilder()->createExpression(Operate::class, $this, 'AND', $expr);
    }

    /**
     * @return Operate
     */
    public function _not_(){
        return $this->getBuilder()->createExpression(Operate::class, new Ignore, 'NOT', $this);
    }

    /**
     * @return Parentheses
     */
    public function _(){
        return $this->getBuilder()->createExpression(Parentheses::class, $this);
    }
}