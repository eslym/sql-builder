<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/1/2019
 * Time: 4:35 PM
 */

namespace Eslym\SqlBuilder\Dml;


use Eslym\SqlBuilder\Dml\Interfaces\Operand;
use Eslym\SqlBuilder\Dml\Traits\Operand as OperandImpl;

class Operate extends Merge implements Operand
{
    use OperandImpl;

    /**
     * BiOperator constructor.
     * @param Builder $builder
     * @param mixed $left
     * @param string $operator
     * @param mixed $right
     */
    public function __construct($builder, $left, $operator, $right)
    {
        if($left instanceof SqlCase){
            $left = $left->_();
        }
        if ($right instanceof Ignore) {
            parent::__construct($builder, $left, $builder->raw($operator));
            return;
        }
        if($right instanceof Operate || $right instanceof SqlCase){
            $right = $right->_();
        }
        if($left instanceof Ignore){
            parent::__construct($builder, $builder->raw($operator), $right);
        } else {
            parent::__construct($builder, $left, $builder->raw($operator), $right);
        }
    }
}