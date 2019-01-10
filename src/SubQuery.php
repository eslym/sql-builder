<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10/1/2019
 * Time: 4:03 PM
 */

namespace Eslym\SqlBuilder\Dml;


use Eslym\SqlBuilder\Dml\Interfaces\DataSource;
use Eslym\SqlBuilder\Dml\Traits\DataSource as DataSourceImpl;
use Eslym\SqlBuilder\Dml\Traits\Joinable;
use Eslym\SqlBuilder\Dml\Traits\Selectable;

class SubQuery extends Expression implements DataSource
{
    use DataSourceImpl, Joinable, Selectable;

    /**
     * @var Select
     */
    protected $__source;

    public function __construct($builder, $source, $alias)
    {
        parent::__construct($builder);
        $this->__source = $source;
        $this->__alias = $alias;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->getAlias();
    }

    /**
     * @return string
     */
    public function getWrappedName(): string
    {
        return $this->getBuilder()->wrap($this->getAlias());
    }

    /**
     * @return string
     */
    function toSql(): string
    {
        return $this->__source->toSql();
    }

    public function toSelectSql(): string
    {
        return sprintf('(%s) AS %s', $this->toSql(), $this->getWrappedName());
    }

    public function bindings(): array
    {
        return $this->__source->bindings();
    }
}