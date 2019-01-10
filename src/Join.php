<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10/1/2019
 * Time: 12:26 PM
 */

namespace Eslym\SqlBuilder\Dml;


use EsLym\LightStream\Stream;
use Eslym\SqlBuilder\Dml\Interfaces\DataSource;
use Eslym\SqlBuilder\Dml\Interfaces\Aliasable;
use Eslym\SqlBuilder\Dml\Traits\Joinable;
use Eslym\SqlBuilder\Dml\Traits\Selectable;

class Join extends Expression implements Aliasable
{
    use Joinable, Selectable;

    /**
     * @var DataSource|Join
     */
    protected $from;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var Expression|DataSource|Aliasable
     */
    protected $join;

    /**
     * @var Expression
     */
    protected $on;

    protected $index = 1;

    /**
     * Join constructor.
     * @param Builder $builder
     * @param $from
     * @param $join
     * @param string $type
     */
    public function __construct($builder, $from, $join, $type = 'inner')
    {
        parent::__construct($builder);
        $this->from = $builder->table($from);
        $this->join = $builder->table($join);
        $this->type = $type;
    }

    /**
     * @param static|null &$var
     * @param null|string $asName
     * @return static
     */
    public function as(&$var, $asName = null){
        $this->join->as($var, $asName);
        return $this;
    }

    /**
     * @param string|null $asName
     * @return static
     */
    public function asName($asName = null){
        $this->join->asName($asName);
        return $this;
    }

    /**
     * @param DataSource $join
     * @param string $type
     * @return Join
     */
    public function join($join, $type = 'inner'){
        $join = $this->getBuilder()
            ->createExpression(Join::class, $this, $join, $type);
        $join->index += 1;
        if($join->join->getAlias() === null){
            $join->join->asName('t'.$join->index);
        }
        return $join;
    }

    /**
     * @param $expr
     * @return $this
     */
    public function on($expr){
        $this->on = $expr;
        return $this;
    }

    /**
     * @return string
     */
    function toSql(): string
    {
        $sql = $this->from->toSelectSql();
        $sql.= ' '.strtoupper($this->type).' JOIN ';
        $sql.= $this->join->toSelectSql();
        if($this->on !== null){
            $sql.= ' ON '.$this->on->toSql();
        }
        return $sql;
    }

    /**
     * @return array
     */
    public function bindings(): array
    {
        $bind = Stream::of($this->from->bindings())
            ->concat($this->join->bindings());
        if($this->on !== null){
            $bind = $bind->concat($this->on->bindings());
        }
        return $bind->flatten()->collect();
    }

    /**
     * @return string
     */
    public function toSelectSql(): string
    {
        return $this->toSql();
    }
}