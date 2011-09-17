<?php

class Sj_Rounder_DownRounder extends Sj_Rounder_AbstractRounder implements Sj_Rounder_Rounder
{
    /**
     * @param string $val
     * @param int $scaleToRound
     *
     * @return string
     */
    public function round($val, $scaleToRound = 0)
    {
        $scale = $this->extractScaleFromString($val);

        $pointShiftedVal = $this->shiftPointRight($val, $scaleToRound, $scale);
        $intPart = $this->extractIntegerPart($pointShiftedVal);
        return $this->shiftPointLeft($intPart, $scaleToRound, $scaleToRound);
    }
}
