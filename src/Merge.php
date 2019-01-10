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
        $this->expressions = Stream::of($expressions)->map([$this->getBuilder(), 'val']);
    }

    /**
     * @return string
     */
    function toSql(): string
    {
        return join(' ', $this->expressions->map(Invoke::toSql())->collect());
    }

    /**
     * @return array
     */
    function bindings(): array
    {
        return $this->expressions->map(Invoke::bindings())->flatten()->collect();
    }
}