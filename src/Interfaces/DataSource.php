<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/1/2019
 * Time: 12:33 PM
 */

namespace Eslym\SqlBuilder\Dml\Interfaces;


use Eslym\SqlBuilder\Dml\Column;

interface DataSource extends Selectable
{
    /**
     * @param $name
     * @return Column
     */
    public function __get($name);

    /**
     * @param static|null &$var
     * @param string $asName
     * @return $this
     */
    public function as(&$var, $asName = null);

    /**
     * @param string $name
     * @return $this
     */
    public function asName($name = null);

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getWrappedName(): string;
}