<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/1/2019
 * Time: 8:35 PM
 */

namespace Eslym\SqlBuilder\Dml\Helpers;


use Eslym\SqlBuilder\Dml\Builder;

class func
{
    /**
     * @param $name
     * @param $arguments
     * @return \Eslym\SqlBuilder\Dml\SqlFunc
     */
    public static function __callStatic($name, $arguments)
    {
        return sql::func($name, ...$arguments);
    }

    protected $builder;

    /**
     * func constructor.
     * @param Builder $builder
     */
    public function __construct($builder)
    {
        $this->builder = $builder;
    }

    /**
     * @param $name
     * @param $arguments
     * @return \Eslym\SqlBuilder\Dml\SqlFunc
     */
    public function __call($name, $arguments)
    {
        return $this->builder->func($name, ...$arguments);
    }
}