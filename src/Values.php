<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/1/2019
 * Time: 7:54 PM
 */

namespace Eslym\SqlBuilder\Dml;


use EsLym\LightStream\Stream;

class Values extends Expression
{
    protected $values;

    public function __construct($builder, $values)
    {
        parent::__construct($builder);
        $this->values = Stream::of($values)->map([$builder, 'val']);
    }

    /**
     * @return string
     */
    function toSql(): string
    {
        return '('.join(', ', $this->values->map(Invoke::toSql())->collect()).')';
    }

    /**
     * @return array
     */
    function bindings(): array
    {
        return $this->values->map(Invoke::bindings())->flatten()->collect();
    }
}