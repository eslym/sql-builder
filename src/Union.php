<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10/1/2019
 * Time: 4:35 PM
 */

namespace Eslym\SqlBuilder\Dml;


use EsLym\LightStream\Stream;
use Eslym\SqlBuilder\Dml\Traits\Limitable;
use Eslym\SqlBuilder\Dml\Traits\Queryable;
use Eslym\SqlBuilder\Dml\Traits\Sortable;
use Eslym\SqlBuilder\Dml\Traits\Unionable;

class Union extends Expression
{
    use Queryable, Unionable, Sortable, Limitable;

    /**
     * @var Select
     */
    protected $firstQuery;

    /**
     * @var Select
     */
    protected $secondQuery;

    /**
     * @var string
     */
    protected $type;

    /**
     * Union constructor.
     * @param Builder $builder
     * @param Select|Union $firstQuery
     * @param Select|Union $secondQuery
     */
    public function __construct($builder, $firstQuery, $secondQuery, $type = null)
    {
        parent::__construct($builder);
        $this->firstQuery = $firstQuery;
        $this->secondQuery = $secondQuery;
        $this->type = $type;
    }

    /**
     * @return string
     */
    function toSql(): string
    {
        if($this->orders === null && $this->limit){
            return $this->originalSql();
        }
        $sql = '('.$this->originalSql().')';
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

    function bindings(): array
    {
        if($this->orders === null){
            return $this->originalBindings();
        }
        $bind = Stream::of($this->originalBindings());
        $bind = $bind->concat($this->orders->map(Invoke::bindings()));
        return $bind->flatten()->collect();
    }

    protected function originalSql(){
        $first = $this->firstQuery instanceof Union ?
            $this->firstQuery->originalSql() :
            $this->firstQuery->toSql();
        $second = $this->secondQuery instanceof Union ?
            $this->secondQuery->originalSql() :
            $this->secondQuery->toSql();
        $union = ' UNION ';
        if($this->type !== null){
            $union = ' '.strtoupper($this->type).$union;
        }
        return $first.$union.$second;
    }

    protected function originalBindings(){
        $first = $this->firstQuery instanceof Union ?
            $this->firstQuery->originalBindings() :
            $this->firstQuery->bindings();
        $second = $this->secondQuery instanceof Union ?
            $this->secondQuery->originalBindings() :
            $this->secondQuery->bindings();
        return Stream::of($first)->concat($second)->flatten()->collect();
    }
}