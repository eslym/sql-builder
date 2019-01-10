<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/1/2019
 * Time: 7:36 PM
 */

namespace Eslym\SqlBuilder\Dml;

use Carbon\Carbon;
use Eslym\LightStream\Stream;
use Eslym\SqlBuilder\Dml\Interfaces\DataSource;
use Eslym\SqlBuilder\Dml\Interfaces\Operand;
use Eslym\SqlBuilder\Dml\Interfaces\Aliasable;
use Eslym\SqlBuilder\Dml\Wrappers\GraveWrapper;

class Builder
{
    /**
     * @var callable
     */
    protected $wrapper;

    /**
     * @var callable
     */
    protected $tableWrapper;

    public function __construct()
    {
        $this->wrapper = new GraveWrapper();
        $this->tableWrapper = new GraveWrapper();
    }

    /**
     * @param $name
     * @return Table
     */
    public function __get($name)
    {
        return $this->table($name);
    }

    /**
     * @param $name
     * @return Table|DataSource|Join
     */
    public function table($name){
        if($name instanceof DataSource || $name instanceof Join){
            return $name;
        }
        return $this->createExpression(Table::class, $name);
    }

    /**
     * @param mixed $value
     * @return Expression|Operand
     */
    public function val($value){
        if($value instanceof Expression){
            return $value;
        }
        if(Stream::isIterable($value)){
            return $this->createExpression(Values::class, $value);
        }
        if($value instanceof \DateTimeInterface){
            $value = $value->format('Y-m-d H:i:s');
        }
        return $this->createExpression(Value::class, $value);
    }

    /**
     * @param string $name
     * @param mixed ...$arguments
     * @return SqlFunc
     */
    public function func($name, ...$arguments){
        return new SqlFunc($this, $name, $arguments);
    }

    /**
     * @param mixed
     * @return Expression|Operand|Aliasable
     */
    public function date($date){
        return $this->val(Carbon::parse($date)->toDateString());
    }

    /**
     * @param mixed
     * @return Expression|Operand|Aliasable
     */
    public function time($date){
        return $this->val(Carbon::parse($date)->toTimeString());
    }

    /**
     * @return AllColumn
     */
    public function allColumn(){
        return $this->createExpression(AllColumn::class);
    }

    /**
     * @param string $sql
     * @param mixed ...$bindings
     * @return Raw
     */
    public function raw($sql, ...$bindings){
        return $this->createExpression(Raw::class, $sql, ...$bindings);
    }

    /**
     * @param callable $wrapper
     * @return Builder
     */
    public function setWrapper(callable $wrapper)
    {
        $this->wrapper = $wrapper;
        return $this;
    }

    /**
     * @param callable $tableWrapper
     * @return Builder
     */
    public function setTableWrapper(callable $tableWrapper)
    {
        $this->tableWrapper = $tableWrapper;
        return $this;
    }

    /**
     * @param string $column
     * @return string
     */
    public function wrap($column){
        return ($this->wrapper)($column);
    }

    /**
     * @param string $table
     * @return string
     */
    public function wrapTable($table){
        return ($this->tableWrapper)($table);
    }

    /**
     * @param string $class
     * @param mixed ...$params
     * @return mixed
     */
    public function createExpression($class, ...$params){
        return new $class($this, ...$params);
    }
}