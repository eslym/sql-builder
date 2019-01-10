<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/1/2019
 * Time: 12:17 PM
 */

namespace Eslym\SqlBuilder\Dml\Wrappers;


class GraveWrapper
{
    /**
     * @var string
     */
    protected $prefix;

    /**
     * @var string
     */
    protected $suffix;

    public function __invoke($string)
    {
        $string = $this->prefix.$string.$this->suffix;
        return '`'.str_replace('`', '``', $string).'`';
    }

    public function __construct($prefix = '', $suffix='')
    {
        $this->prefix = $prefix;
        $this->suffix = $suffix;
    }
}