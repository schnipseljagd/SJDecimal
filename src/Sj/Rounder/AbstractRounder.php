<?php

abstract class Sj_Rounder_AbstractRounder
{
    /**
     * @param string $val
     * @param int $steps
     * @param int $scale
     *
     * @return string
     */
    public function shiftPointRight($val, $steps, $scale)
    {
        return bcmul($val, bcpow('10', $steps), $scale);
    }

    /**
     * @param string $val
     * @param int $steps
     * @param int $scale
     *
     * @return string
     */
    public function shiftPointLeft($val, $steps, $scale)
    {
        return bcdiv($val, bcpow('10', $steps), $scale);
    }

    /**
     * @param string $val
     * @param int $scale
     *
     * @return string
     */
    public function extractDecimalPart($val, $scale)
    {
        return bcsub($val, $this->extractIntegerPart($val), $scale + 1);
    }

    /**
     * @param string $v
     *
     * @return string
     */
    public function extractIntegerPart($v)
    {
        $parts = explode('.', $v);
        return $parts[0];
    }

    /**
     * @param $val
     * @return integer
     */
    protected function extractScaleFromString($val)
    {
        $valOperator = new Sj_DecimalString($val);
        return $valOperator->getScale();
    }
}
