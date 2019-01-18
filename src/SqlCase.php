<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/1/2019
 * Time: 5:59 PM
 */

namespace Eslym\SqlBuilder\Dml;


use Eslym\LightStream\Invoke;
use Eslym\LightStream\Stream;
use Eslym\SqlBuilder\Dml\Interfaces\Operand;
use Eslym\SqlBuilder\Dml\Traits\Operand as OperandImpl;

class SqlCase extends Expression implements Operand
{
    use OperandImpl;

    /**
     * @var Expression|Operand
     */
    protected $case;

    /**
     * @var Expression[][]
     */
    protected $when = [];

    /**
     * @var Expression|Operand
     */
    protected $else = null;

    /**
     * SqlCase constructor.
     * @param Builder $builder
     * @param $case
     */
    public function __construct($builder, $case)
    {
        parent::__construct($builder);
        $this->case = $builder->val($case);
    }

    function _when_($case, $expr){
        $builder = $this->getBuilder();
        array_push($this->when, [$builder->val($case), $builder->val($expr)]);
        return $this;
    }

    function _else_($expr){
        $this->else = $this->getBuilder()->val($expr);
        return $this;
    }

    /**
     * @return string
     */
    function toSql(): string
    {
        $sql = 'CASE '.$this->case->toSql();
        foreach ($this->when as $when){
            $sql.= ' WHEN '.$when[0]->toSql().' THEN '.$when[1]->toSql();
        }
        if($this->else !== null){
            $sql.= ' ELSE '.$this->else->toSql();
        }
        $sql .= ' END';
        return $sql;
    }

    public function bindings(): array
    {
        $bind = Stream::of([$this->case])
            ->concat($this->when)
            ->map(Invoke::bindings());
        if($this->else !== null){
            $bind = $bind->concat($this->else->bindings());
        }
        return $bind->flatten()->collect();
    }
}