<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/1/2019
 * Time: 8:15 PM
 */

namespace Eslym\SqlBuilder\Dml;


use EsLym\LightStream\Stream;
use Eslym\SqlBuilder\Dml\Interfaces\Operand;
use Eslym\SqlBuilder\Dml\Traits\Operand as OperandImpl;

class SqlFunc extends Expression implements Operand
{
    use OperandImpl;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var iterable
     */
    protected $arguments;

    /**
     * SqlFunc constructor.
     * @param Builder $builder
     * @param string $name
     * @param $arguments
     */
    public function __construct($builder, $name, $arguments)
    {
        parent::__construct($builder);
        $this->name = $name;
        $this->arguments = $arguments;
    }

    /**
     * @return string
     */
    function toSql(): string
    {
        $this->arguments->rewind();
        return strtoupper($this->name).'('.
            join(', ',
                Stream::of($this->arguments)
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
        return Stream::of($this->arguments)
            ->map([$this->getBuilder(), 'val'])
            ->map(Invoke::bindings())
            ->flatten()
            ->collect();
    }

    /**
     * @return $this|Parentheses
     */
    public function _()
    {
        return $this;
    }
}