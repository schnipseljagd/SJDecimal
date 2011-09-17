<?php

class Sj_Rounder_HalfUpRounder extends Sj_Rounder_AbstractRounder implements Sj_Rounder_Rounder
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
        $integerPart = $this->extractIntegerPart($pointShiftedVal);
        $decimalPart = $this->extractDecimalPart($pointShiftedVal, $scaleToRound);

        // decimal after scale < 5
        if (!$this->decimalPartLessThanZeroPointFive($decimalPart)) {
            $integerPart = bcadd($integerPart, '1');
        }

        return $this->shiftPointLeft($integerPart, $scaleToRound, $scaleToRound);
    }

    /**
     * @param string $decimalPart
     * @return bool
     */
    private function decimalPartLessThanZeroPointFive($decimalPart)
    {
        return -1 === bccomp($decimalPart, '0.5', 1);
    }

}
