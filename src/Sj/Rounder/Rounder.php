<?php

interface Sj_Rounder_Rounder
{
    /**
     * @param float $val
     * @param int $precision
     * @return float|int
     */
    public function round($val, $precision = 0);
}
