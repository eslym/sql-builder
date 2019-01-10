<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/1/2019
 * Time: 12:46 PM
 */

namespace Eslym\SqlBuilder\Dml\Interfaces;


interface Aliasable
{
    /**
     * @param static &$var
     * @param string|null $name
     * @return static
     */
    public function as(&$var, $name = null);

    /**
     * @param string|null $name
     * @return static
     */
    public function asName($name = null);

    /**
     * @return string
     */
    public function toSelectSql(): string;
}