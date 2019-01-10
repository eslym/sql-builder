<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/1/2019
 * Time: 6:02 PM
 */

namespace Eslym\SqlBuilder\Dml;


use Eslym\SqlBuilder\Dml\Interfaces\Operand;
use Eslym\SqlBuilder\Dml\Traits\Operand as OperandImpl;

class Parentheses extends Expression implements Operand
{
    use OperandImpl;

    /**
     * @var Expression
     */
    protected $inner;

    /**
     * Parentheses constructor.
     * @param Builder $builder
     * @param $inner
     */
    public function __construct($builder, $inner)
    {
        parent::__construct($builder);
        $this->inner = $builder->val($inner);
    }

    /**
     * @return string
     */
    function toSql(): string
    {
        return '('.$this->inner.')';
    }

    function bindings(): array
    {
        return $this->inner->bindings();
    }

    /**
     * @return Parentheses
     */
    public function _()
    {
        return $this;
    }
}