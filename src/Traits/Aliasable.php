<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/1/2019
 * Time: 1:13 PM
 */

namespace Eslym\SqlBuilder\Dml\Traits;

use Eslym\SqlBuilder\Dml\Expression;

/**
 * Trait Selectable
 * @package Eslym\SqlBuilder\Dml\Traits
 *
 * @mixin Expression
 */
trait Aliasable
{
    protected $__alias;

    /**
     * @param static|null &$var
     * @param null|string $asName
     * @return static
     */
    public function as(&$var, $asName = null){
        if($asName !== null){
            $this->asName($asName);
        }
        return $var = $this;
    }

    /**
     * @param string|null $asName
     * @return static
     */
    public function asName($asName = null){
        $this->__alias = $asName;
        return $this;
    }

    /**
     * @return string?
     */
    public function getAlias(): ?string {
        return $this->__alias;
    }

    /**
     * @return string
     */
    public function toSelectSql(): string
    {
        if($this->getAlias() !== null){
            $sql = $this->toSql();
            $alias = $this->getBuilder()->wrap($this->getAlias());
            return "$sql AS $alias";
        }
        return $this->toSql();
    }
}