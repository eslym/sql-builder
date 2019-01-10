<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10/1/2019
 * Time: 4:53 PM
 */

namespace Eslym\SqlBuilder\Dml\Traits;

use EsLym\LightStream\Stream;
use Eslym\SqlBuilder\Dml\Expression;
use Eslym\SqlBuilder\Dml\Merge;
use Eslym\SqlBuilder\Dml\Select;

/**
 * Trait Sortable
 * @package Eslym\SqlBuilder\Dml\Traits
 * @mixin Expression
 */
trait Sortable
{
    /**
     * @var Stream
     */
    protected $orders;

    /**
     * @param $expr
     * @param string $order
     * @return $this
     */
    public function orderBy($expr, $order = 'asc'){
        $builder = $this->getBuilder();
        $exp = $builder->createExpression(Merge::class, $expr, $builder->raw(strtoupper($order)));
        if($this->orders === null){
            $this->orders = Stream::of([$exp]);
        } else {
            $this->orders->concat([$exp]);
        }
        return $this;
    }

    /**
     * @param $expr
     * @return $this
     */
    public function orderByAsc($expr){
        return $this->orderBy($expr);
    }

    /**
     * @param $expr
     * @return $this
     */
    public function orderByDesc($expr){
        return $this->orderBy($expr, 'desc');
    }
}