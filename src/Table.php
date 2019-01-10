<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/1/2019
 * Time: 1:20 PM
 */

namespace Eslym\SqlBuilder\Dml;


use Eslym\SqlBuilder\Dml\Interfaces\DataSource;
use Eslym\SqlBuilder\Dml\Interfaces\Aliasable;
use Eslym\SqlBuilder\Dml\Traits\DataSource as DataSourceImpl;
use Eslym\SqlBuilder\Dml\Traits\Joinable;

class Table extends Expression implements Aliasable, DataSource
{
    use DataSourceImpl, Joinable;

    protected $__name;

    /**
     * Table constructor.
     * @param $builder
     * @param string $name
     */
    public function __construct($builder, string $name)
    {
        parent::__construct($builder);
        $this->__name = $name;
    }

    /**
     * @return AllColumn
     */
    public function all(){
        return $this->getBuilder()->createExpression(AllColumn::class, $this);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->__name;
    }

    /**
     * @return string
     */
    public function getWrappedName(): string
    {
        if($this->getAlias() !== null){
            return $this->getBuilder()->wrap($this->getAlias());
        }
        return $this->toSql();
    }

    /**
     * @return string
     */
    function toSql(): string
    {
        return $this->getBuilder()->wrapTable($this->getName());
    }
}