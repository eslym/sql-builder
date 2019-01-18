<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/1/2019
 * Time: 7:54 PM
 */

namespace Eslym\SqlBuilder\Dml;


use Eslym\LightStream\Stream;

class Values extends Expression
{
    protected $values;

    public function __construct($builder, $values)
    {
        parent::__construct($builder);
        $this->values = $values;
    }

    /**
     * @return string
     */
    function toSql(): string
    {
        return '('.join(', ',
                Stream::of($this->values)
                    ->map([$this->getBuilder(), 'val'])
                    ->map(Invoke::toSql())
                    ->collect()
            ).')';
    }

    /**
     * @return array
     */
    function bindings(): array
    {
        return Stream::of($this->values)
            ->map([$this->getBuilder(), 'val'])
            ->map(Invoke::bindings())
            ->flatten()
            ->collect();
    }
}