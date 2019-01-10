<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/1/2019
 * Time: 4:37 PM
 */

namespace Eslym\SqlBuilder\Dml;


use Eslym\LightStream\Stream;

class Raw extends Expression
{
    /**
     * @var string
     */
    protected $sql;

    /**
     * @var iterable
     */
    protected $bindings;

    /**
     * Raw constructor.
     * @param $builder
     * @param $sql
     * @param mixed ...$bindings
     */
    public function __construct($builder, $sql, ...$bindings)
    {
        parent::__construct($builder);
        if(
            count($bindings) ==1 and
            Stream::isIterable($bindings[0])
        ){
            $bindings = $bindings[0];
        }
        $this->sql = $sql;
        $this->bindings = $bindings;
    }

    /**
     * @return string
     */
    function toSql(): string
    {
        return $this->sql;
    }

    /**
     * @return array
     */
    function bindings(): array
    {
        return Stream::of($this->bindings)->collect();
    }
}