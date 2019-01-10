<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/1/2019
 * Time: 4:40 PM
 */

namespace Eslym\SqlBuilder\Dml;


use Eslym\SqlBuilder\Dml\Interfaces\Operand;
use Eslym\SqlBuilder\Dml\Traits\Operand as OperandImpl;

/**
 * Class Value
 * @package Eslym\SqlBuilder\Dml
 */
class Value extends Expression implements Operand
{
    use OperandImpl;

    protected $value;

    /**
     * Value constructor.
     * @param $builder
     * @param $value
     */
    function __construct($builder, $value)
    {
        parent::__construct($builder);
        $this->value = $value;
    }

    /**
     * @return string
     */
    function toSql(): string
    {
        return '?';
    }

    /**
     * @return array
     */
    function bindings(): array
    {
        return [$this->value];
    }
}