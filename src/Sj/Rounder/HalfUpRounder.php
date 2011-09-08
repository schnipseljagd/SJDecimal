<?php

class Sj_Rounder_HalfUpRounder implements Sj_Rounder_Rounder
{
    /**
     * @param float $val
     * @param int $precision
     * @return float|int
     */
    public function round($val, $precision = 0)
    {
        return round($val, $precision);
    }
}
