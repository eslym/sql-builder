<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10/1/2019
 * Time: 5:11 PM
 */

namespace Eslym\SqlBuilder\Dml\Traits;

use Eslym\SqlBuilder\Dml\Expression;

/**
 * Trait Limitable
 * @package Eslym\SqlBuilder\Dml\Traits
 *
 * @mixin Expression
 */
trait Limitable
{
    /**
     * @var int
     */
    protected $limit;

    /**
     * @var int
     */
    protected $offset;

    /**
     * @param int $limit
     * @param int|null $offset
     * @return $this
     */
    public function limit($limit, $offset = null){
        $this->limit = $limit;
        $this->offset = $offset;
        return $this;
    }
}