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
use Eslym\SqlBuilder\Dml\Traits\Unionable;

class Select extends Expression
{
    use Queryable, Sortable, Limitable, Unionable;

    /**
     * @var iterable
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
     * @var iterable
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
        $this->selects = [$builder->allColumn()];
    }

    /**
     * @param mixed ...$selects
     * @return $this
     */
    public function select(...$selects){
        if(count($selects) == 1 && Stream::isIterable($selects[0])){
            $this->selects = $selects[0];
        } else {
            $this->selects = $selects;
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
        $sel = Stream::of($this->selects);
        if(count($selects) == 1 && Stream::isIterable($selects[0])){
            $this->selects = $sel->concat($selects[0])->collect();
        } else {
            $this->selects = $sel->concat($selects)->collect();
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
            $this->groups = $groups[0];
        } else {
            $this->groups = $groups;
        }
        return $this;
    }

    /**
     * @param mixed ...$groups
     * @return $this
     */
    public function addGroup(...$groups){
        $g = Stream::of($this->groups);
        if($this->groups === null){
            $this->groupBy(...$groups);
        } else if(count($groups) == 1 && Stream::isIterable($groups[0])){
            $this->groups = $g->concat($groups[0])->collect();
        } else {
            $this->groups = $g->concat($groups)->collect();
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
        $selects = Stream::of($this->selects);
        $sql = 'SELECT '.join(', ', $selects->map([$this->getBuilder(), 'val'])->map(Invoke::toSelectSql())->collect());
        if($this->from === null){
            return $sql;
        }
        $sql.= ' FROM '.$this->from->toSelectSql();
        if($this->where !== null){
            $sql.= $this->where->toSql();
        }
        if($this->groups !== null){
            $groups = Stream::of($this->groups)
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
            $orders = Stream::of($this->orders);
            $sql.= ' ORDER BY '.join(', ', $orders->map(Invoke::toSql())->collect());
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
        $selects = Stream::of($this->selects);
        $bind = $selects
            ->map([$this->getBuilder(), 'val'])
            ->map(Invoke::bindings());
        if($this->from === null){
            return $bind->flatten()->collect();
        }
        $bind = $bind->concat($this->from->bindings());
        if($this->where !== null){
            $bind = $bind->concat($this->where->bindings());
        }
        if($this->groups !== null){
            $bind = $bind->concat(
                Stream::of($this->groups)
                    ->map([$this->getBuilder(), 'val'])
                    ->map(Invoke::bindings())
            );
        }
        if($this->orders !== null){
            $bind = $bind->concat(Stream::of($this->orders)->map(Invoke::bindings()));
        }
        return $bind->flatten()->collect();
    }


}