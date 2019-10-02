<?php


namespace Eslym\SqlBuilder\Dml\Interfaces;


use Eslym\SqlBuilder\Dml\Join;
use Eslym\SqlBuilder\Dml\Traits\DataSource;

interface Joinable
{
    /**
     * @param DataSource|Join|string $join
     * @param string $type
     * @return Join
     */
    function join($join, $type = 'inner');

    /**
     * @param DataSource|Join|string $join
     * @return Join
     */
    function leftJoin($join);

    /**
     * @param DataSource|Join|string $join
     * @return Join
     */
    function rightJoin($join);
}