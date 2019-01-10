<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/1/2019
 * Time: 11:59 AM
 */

namespace Eslym\SqlBuilder\Dml;


abstract class Expression
{
    /**
     * @var Builder
     */
    protected $__builder;

    public function __construct($builder)
    {
        $this->__builder = $builder;
    }

    /**
     * @return Builder
     */
    public function getBuilder()
    {
        return $this->__builder;
    }

    /**
     * @param Builder $__builder
     * @return Expression
     */
    public function setBuilder(Builder $__builder)
    {
        $this->__builder = $__builder;
        return $this;
    }

    /**
     * @return string
     */
    abstract function toSql(): string;

    /**
     * @return array
     */
    function bindings(): array
    {
        return [];
    }
}