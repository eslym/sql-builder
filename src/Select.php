<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/1/2019
 * Time: 8:42 PM
 */

namespace Eslym\SqlBuilder\Dml;


use Eslym\LightStream\Invoke;
use Eslym\LightStream\Stream;
use Eslym\SqlBuilder\Dml\Interfaces\DataSource;
use Eslym\SqlBuilder\Dml\Traits\Limitable;
use Eslym\SqlBuilder\Dml\Traits\Queryable;
use Eslym\SqlBuilder\Dml\Traits\Sortable;

class Select extends Expression
{
    use Queryable, Sortable, Limitable;

    /**
     * @var Stream
     */
    protected $selects;

    /**
     * @var DataSource|Join
     */
    protected $from;

    /**
     * @var Expression
     */
    protected $where;

    /**
     * @var Stream
     */
    protected $groups;

    /**
     * @var Expression
     */
    protected $having;

    /**
     * Select constructor.
     * @param Builder $builder
     */
    public function __construct($builder)
    {
        parent::__construct($builder);
        $this->selects = Stream::of([$builder->allColumn()]);
    }

    /**
     * @param mixed ...$selects
     * @return $this
     */
    public function select(...$selects){
        if(count($selects) == 1 && Stream::isIterable($selects[0])){
            $this->selects = Stream::of($selects[0]);
        } else {
            $this->selects = Stream::of($selects);
        }
        return $this;
    }

    /**
     * @param DataSource|Join $source
     * @return Select
     */
    public function from($source){
        $this->from = $this->getBuilder()->table($source);
        return $this;
    }

    /**
     * @param mixed ...$selects
     * @return $this
     */
    public function addSelect(...$selects){
        if(count($selects) == 1 && Stream::isIterable($selects[0])){
            $this->selects = $this->selects->concat($selects[0]);
        } else {
            $this->selects = $this->selects->concat($selects);
        }
        return $this;
    }

    /**
     * @param $expr
     * @return $this
     */
    public function where($expr){
        $this->where = $this->getBuilder()->val($expr);
        return $this;
    }

    /**
     * @param mixed ...$groups
     * @return $this
     */
    public function groupBy(...$groups){
        if(count($groups) == 1 && Stream::isIterable($groups[0])){
            $this->groups = Stream::of($groups[0]);
        } else {
            $this->groups = Stream::of($groups);
        }
        return $this;
    }

    /**
     * @param mixed ...$groups
     * @return $this
     */
    public function addGroup(...$groups){
        if($this->groups === null){
            $this->groupBy(...$groups);
        } else if(count($groups) == 1 && Stream::isIterable($groups[0])){
            $this->groups = $this->selects->concat($groups[0]);
        } else {
            $this->groups = $this->selects->concat($groups);
        }
        return $this;
    }

    /**
     * @param $expr
     * @return $this
     */
    public function having($expr){
        $this->having = $this->getBuilder()->val($expr);
        return $this;
    }

    /**
     * @return $this
     */
    public function clearOrder(){
        $this->orders = null;
        return $this;
    }

    /**
     * @return string
     */
    public function toSql(): string
    {
        $sql = 'SELECT '.join(', ', $this->selects->map(Invoke::toSql())->collect());
        if($this->from === null){
            return $sql;
        }
        $sql.= ' FROM '.$this->from->toSelectSql();
        if($this->where !== null){
            $sql.= $this->where->toSql();
        }
        if($this->groups !== null){
            $groups = $this->groups
                ->map([$this->getBuilder(), 'val'])
                ->map(Invoke::toSql())
                ->collect();
            if(count($groups) > 0){
                $sql.= ' GROUP BY '.join(', ', $groups);
                if($this->having !== null){
                    $sql.= $this->having->toSql();
                }
            }
        }
        if($this->orders !== null){
            $sql.= ' ORDER BY '.join(', ', $this->orders->map(Invoke::toSql())->collect());
        }
        if($this->limit !== null){
            $sql.= sprintf(' LIMIT %d', $this->limit);
            if($this->offset !== null){
                $sql.= sprintf(' OFFSET %d', $this->offset);
            }
        }
        return $sql;
    }

    public function bindings(): array
    {
        $bind = $this->selects->map(Invoke::bindings());
        if($this->from === null){
            return $bind->flatten()->collect();
        }
        $bind = $bind->concat($this->from->bindings());
        if($this->where !== null){
            $bind = $bind->concat($this->where->bindings());
        }
        if($this->groups !== null){
            $bind = $bind->concat(
                $this->groups
                    ->map([$this->getBuilder(), 'val'])
                    ->map(Invoke::bindings())
            );
        }
        if($this->orders !== null){
            $bind = $bind->concat($this->orders->map(Invoke::bindings()));
        }
        return $bind->flatten()->collect();
    }


}