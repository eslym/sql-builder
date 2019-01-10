<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/1/2019
 * Time: 12:43 PM
 */

namespace Eslym\SqlBuilder\Dml;


use Eslym\SqlBuilder\Dml\Interfaces\DataSource;
use Eslym\SqlBuilder\Dml\Interfaces\Operand;
use Eslym\SqlBuilder\Dml\Interfaces\Aliasable;
use Eslym\SqlBuilder\Dml\Traits\Operand as OperandImpl;

class Column extends Expression implements Aliasable, Operand
{
    use OperandImpl;

    /**
     * @var DataSource
     */
    protected $dataSource;

    /**
     * @var string
     */
    protected $name;

    /**
     * Column constructor.
     * @param Builder $builder
     * @param DataSource $dataSource
     * @param string $name
     */
    public function __construct($builder, $dataSource, $name)
    {
        parent::__construct($builder);
        $this->dataSource = $dataSource;
        $this->name = $name;
    }

    /**
     * @return string
     */
    function toSql(): string
    {
        $table = $this->dataSource->getWrappedName();
        $name = $this->getBuilder()->wrap($this->name);
        return "$table.$name";
    }

    /**
     * @param $value
     * @return Set
     */
    function _set_($value){
        $builder = $this->getBuilder();
        return $builder->createExpression(Set::class, $this, $builder->val($value));
    }

    /**
     * @param $expr
     * @return Set
     */
    function _setAdd_($expr){
        return $this->_set_($this->_add_($expr));
    }

    /**
     * @param $expr
     * @return Set
     */
    function _setSub_($expr){
        return $this->_set_($this->_sub_($expr));
    }

    /**
     * @param $expr
     * @return Set
     */
    function _setMul_($expr){
        return $this->_set_($this->_mul_($expr));
    }

    /**
     * @param $expr
     * @return Set
     */
    function _setDiv_($expr){
        return $this->_set_($this->_div_($expr));
    }

    /**
     * @param $expr
     * @return Set
     */
    function _setMod_($expr){
        return $this->_set_($this->_mod_($expr));
    }
}