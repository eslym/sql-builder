<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/1/2019
 * Time: 11:06 AM
 */

namespace Eslym\SqlBuilder\Dml\Helpers;


use Eslym\SqlBuilder\Dml\AllColumn;
use Eslym\SqlBuilder\Dml\Builder;
use Eslym\SqlBuilder\Dml\Expression;
use Eslym\SqlBuilder\Dml\Interfaces\Aliasable;
use Eslym\SqlBuilder\Dml\Interfaces\DataSource;
use Eslym\SqlBuilder\Dml\Interfaces\Operand;
use Eslym\SqlBuilder\Dml\Raw;
use Eslym\SqlBuilder\Dml\SqlFunc;
use Eslym\SqlBuilder\Dml\Table;

/**
 * Class sql
 * @package Eslym\SqlBuilder\Dml\Helpers
 *
 * @method static Table table(DataSource|string $name)
 * @method static Expression|Operand val($value)
 * @method static SqlFunc func(string $name, ...$arguments)
 * @method static Expression|Operand|Aliasable date($date)
 * @method static AllColumn allColumn()
 * @method static Raw raw(string $sql, ...$bindings)
 * @method static Builder setWrapper(callable $wrapper)
 * @method static Builder setTableWrapper(callable $tableWrapper)
 * @method static string wrap(string $column)
 * @method static string wrapTable(string $table)
 * @method static mixed createExpression(string $class, ...$params)
 */
class sql
{
    /**
     * @var Builder
     */
    protected static $builder;

    /**
     * @return Builder
     */
    public static function getBuilder(){
        return static::$builder === null ?
            static::$builder = new Builder() :
            static::$builder;
    }

    /**
     * @param mixed $builder
     */
    public static function setBuilder($builder)
    {
        self::$builder = $builder;
    }

    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([static::getBuilder(), $name], $arguments);
    }
}