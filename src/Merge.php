<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/1/2019
 * Time: 4:16 PM
 */

namespace Eslym\SqlBuilder\Dml;


use Eslym\LightStream\Invoke;
use EsLym\LightStream\Stream;

class Merge extends Expression
{
    public $expressions;

    public function __construct($builder, ...$expressions)
    {
        parent::__construct($builder);
        $this->expressions = $expressions;
    }

    /**
     * @return string
     */
    function toSql(): string
    {
        $expr = Stream::of($this->expressions)
            ->map([$this->getBuilder(), 'val']);
        return join(' ', $expr->map(Invoke::toSql())->collect());
    }

    /**
     * @return array
     */
    function bindings(): array
    {
        $expr = Stream::of($this->expressions)
            ->map([$this->getBuilder(), 'val']);
        return $expr->map(Invoke::bindings())->flatten()->collect();
    }
}