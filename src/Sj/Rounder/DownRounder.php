<?php

class Sj_Rounder_DownRounder implements Sj_Rounder_Rounder
{
    /**
     * @param float $val
     * @param int $precision
     * @return float|int
     */
    public function round($val, $precision = 0)
    {
        $powerOfTen = pow(10, $precision);

        return floor($val * $powerOfTen) / $powerOfTen;
    }
}
