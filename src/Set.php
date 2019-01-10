<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/1/2019
 * Time: 2:53 PM
 */

namespace Eslym\SqlBuilder\Dml;



use Eslym\SqlBuilder\Dml\Interfaces\Aliasable;

class Set extends Expression
{
    /**
     * @var Column
     */
    protected $column;

    /**
     * @var Aliasable|Expression
     */
    protected $value;

    /**
     * Set constructor.
     * @param Builder $builder
     * @param Column $column
     * @param Aliasable|Expression $value
     */
    public function __construct($builder, $column, $value)
    {
        parent::__construct($builder);
        $this->column = $column;
        $this->value = $value;
    }

    /**
     * @return string
     */
    function toSql(): string
    {
        return $this->column->toSql().' = '.$this->value->toSql();
    }

    /**
     * @return array
     */
    public function bindings(): array
    {
        return $this->value->bindings();
    }
}