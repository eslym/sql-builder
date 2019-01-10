<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/1/2019
 * Time: 2:56 PM
 */

namespace Eslym\SqlBuilder\Dml\Interfaces;


use Eslym\SqlBuilder\Dml\Operate;
use Eslym\SqlBuilder\Dml\Parentheses;
use Eslym\SqlBuilder\Dml\SqlCase;

interface Operand extends Aliasable
{
    #region Arithmetic
    /**
     * @param $expr
     * @return Operate
     */
    public function _add_($expr);

    /**
     * @param $expr
     * @return Operate
     */
    public function _sub_($expr);

    /**
     * @param $expr
     * @return Operate
     */
    public function _mul_($expr);

    /**
     * @param $expr
     * @return Operate
     */
    public function _div_($expr);

    /**
     * @param $expr
     * @return Operate
     */
    public function _mod_($expr);
    #endregion

    #region Bitwise

    /**
     * @param $expr
     * @return Operate
     */
    public function _bitAnd_($expr);

    /**
     * @param $expr
     * @return Operate
     */
    public function _bitOr_($expr);

    /**
     * @param $expr
     * @return Operate
     */
    public function _bitXor_($expr);

    /**
     * @param $expr
     * @return Operate
     */
    public function _lShift_($expr);

    /**
     * @param $expr
     * @return Operate
     */
    public function _rShift_($expr);
    #endregion

    #region Comparison

    /**
     * @param $expr
     * @return Operate
     */
    public function _eql_($expr);

    /**
     * @param $expr
     * @return Operate
     */
    public function _equal_($expr);

    /**
     * @param $expr
     * @return Operate
     */
    public function _gt_($expr);

    /**
     * @param $expr
     * @return Operate
     */
    public function _lt_($expr);

    /**
     * @param $expr
     * @return Operate
     */
    public function _gtEq_($expr);

    /**
     * @param $expr
     * @return Operate
     */
    public function _ltEq_($expr);

    /**
     * @param $expr
     * @return Operate
     */
    public function _notEql_($expr);

    /**
     * @param $case
     * @param $expr
     * @return SqlCase
     */
    public function _when_($case, $expr);

    /**
     * @param $expr
     * @return Operate
     */
    public function _like_($expr);

    /**
     * @param $expr
     * @return Operate
     */
    public function _is_($expr);

    /**
     * @param $min
     * @param $max
     * @return Operate
     */
    public function _between_($min, $max);

    /**
     * @param $expr
     * @return Operate
     */
    public function _in_($expr);
    #endregion

    #region Logic

    /**
     * @param $expr
     * @return Operate
     */
    public function _or_($expr);

    /**
     * @param $expr
     * @return Operate
     */
    public function _and_($expr);

    /**
     * @return Operate
     */
    public function _not_();
    #endregion

    /**
     * @return Parentheses
     */
    public function _();
}