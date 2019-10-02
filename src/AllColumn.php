<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10/1/2019
 * Time: 1:50 PM
 */

namespace Eslym\SqlBuilder\Dml;


use Eslym\SqlBuilder\Dml\Interfaces\DataSource;

class AllColumn extends Expression
{
    /**
     * @var DataSource
     */
    protected $dataSource;

    /**
     * AllColumn constructor.
     * @param Builder $builder
     * @param DataSource $dataSource
     */
    public function __construct($builder, $dataSource = null)
    {
        parent::__construct($builder);
        $this->dataSource = $dataSource;
    }

    /**
     * @return string
     */
    function toSql(): string
    {
        if($this->dataSource !== null){
            return $this->dataSource->getWrappedName().'.*';
        }
        return '*';
    }

    /**
     * @return string
     */
    function toSelectSql():string
    {
        return $this->toSql();
    }
}