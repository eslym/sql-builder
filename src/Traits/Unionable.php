<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10/1/2019
 * Time: 4:25 PM
 */

namespace Eslym\SqlBuilder\Dml\Traits;

use Eslym\SqlBuilder\Dml\Expression;
use Eslym\SqlBuilder\Dml\Select;
use Eslym\SqlBuilder\Dml\Union;

/**
 * Trait Unionable
 * @package Eslym\SqlBuilder\Dml\Traits
 * @mixin Expression
 */
trait Unionable
{
    /**
     * @param Select $select
     * @param null|string $type
     * @return Union
     */
    public function union($select, $type = null){
        return $this->getBuilder()->createExpression(Union::class, $this, $select, $type);
    }

    public function unionAll($select){
        return $this->union($select, 'all');
    }

    public function unionDistinct($select){
        return $this->union($select, 'distinct');
    }
}