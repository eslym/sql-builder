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
     * @param static &$var
     * @param string|null $name
     * @return static
     */
    public function as(&$var, $name = null)
    {
        $this->from->as($var, $name);
        return $this;
    }

    /**
     * @param string|null $name
     * @return static
     */
    public function asName($name = null)
    {
        $this->from->asName($name);
        return $this;
    }

    /**
     * @return string
     */
    public function toSelectSql(): string
    {
        return $this->toSql();
    }
}