<?php

class Sj_Decimal
{
    const MAX_SCALE = 20;
    const FIX_SCALE = 6;

    /**
     * @var string
     */
    private $value;
    /**
     * @var integer
     */
    private $scale;

    /**
     * @param string $value must be numerical
     * @param integer|null $scale
     */
    public function __construct($value, $scale = null)
    {
        Sj_DecimalString::assertNumerical($value);

        $this->scale = (int)$scale;
        $this->value = (string)$value;
    }

    /**
     * @throws InvalidArgumentException
     * @param mixed $value
     * @return Sj_Decimal
     */
    public static function valueOf($value)
    {
        $decimalString = self::createDecimalString($value);

        if (is_integer($value)) {
            return new self($value, 0);
        }
        if (is_double($value)) {
            return new self($value, $decimalString->getScale());
        }
        if (is_string($value)) {
            return new self($value, $decimalString->getScale());
        }
        throw new InvalidArgumentException('value is not of an expected type.');
    }

    /**
     * @param Sj_Decimal $addend
     * @return Sj_Decimal
     */
    public function add(Sj_Decimal $addend)
    {
        $newScale = $this->maxScale($addend);
        $newValue = bcadd($this->value, $addend->value, $newScale);

        return $this->createDecimal($newValue, $newScale);
    }

    /**
     * @param Sj_Decimal $subtrahend
     * @return Sj_Decimal
     */
    public function subtract(Sj_Decimal $subtrahend)
    {
        $newScale = $this->maxScale($subtrahend);
        $newValue = bcsub($this->value, $subtrahend->value, $newScale);

        return $this->createDecimal($newValue, $newScale);
    }

    /**
     * @param Sj_Decimal $multiplicand
     * @return Sj_Decimal
     */
    public function multiply(Sj_Decimal $multiplicand)
    {
        $newValue = bcmul($this->value, $multiplicand->value, self::MAX_SCALE);
        
        $newValue = $this->roundValue($newValue, self::FIX_SCALE);
        return $this->createDecimal($newValue, self::FIX_SCALE);
    }

    /**
     * @param Sj_Decimal $divisor
     * @return Sj_Decimal
     */
    public function divide(Sj_Decimal $divisor)
    {
        $newValue = bcdiv($this->value, $divisor->value, self::MAX_SCALE);

        $newValue = $this->roundValue($newValue, self::FIX_SCALE);
        return $this->createDecimal($newValue, self::FIX_SCALE);
    }

    /**
     * @return double
     */
    public function doubleValue()
    {
        return (double)$this->value;
    }

    /**
     * @return integer
     */
    public function integerValue()
    {
        return (int)$this->value;
    }

    /**
     * @return integer
     */
    public function getUnscaledValue()
    {
        if ($this->scale < 0) {
            return (int)$this->value;
        }
        return (int)$this->calcUnscaledValue();
    }

    /**
     * @return integer
     */
    public function getScale()
    {
        return $this->scale;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->value;
    }

    /**
     * @param integer $n
     * @return Sj_Decimal
     */
    public function pow($n)
    {
        $n = (int) $n;
        return $this->createDecimal($this->calcPow($n), $n);
    }

    /**
     * @return integer
     */
    public function getPrecision()
    {
        return strlen($this->getUnscaledValue());
    }

    /**
     * @param integer $scale
     * @param Sj_Rounder_Rounder $rounder
     * @return Sj_Decimal
     */
    public function round($scale, Sj_Rounder_Rounder $rounder = null)
    {
        return self::valueOf(
            $this->roundValue($this->value, $scale, $rounder)
        );
    }

    /**
     * @param Sj_Decimal $other
     * @return boolean
     */
    public function isGreaterThan(Sj_Decimal $other)
    {
        $greatestScale = $this->maxScale($other);
        return (1 == bccomp($this->value, $other->value, $greatestScale));
    }

    /**
     * @param Sj_Decimal $other
     * @return boolean
     */
    public function isLessThan(Sj_Decimal $other)
    {
        $greatestScale = $this->maxScale($other);
        return (-1 == bccomp($this->value, $other->value, $greatestScale));
    }

    /**
     * Two Sj_Decimal objects that are equal in value but have a different scale (like 2.0 and 2.00) are considered
     * equal by this method.
     * @param Sj_Decimal $other
     * @return boolean
     */
    public function hasEqualValueTo(Sj_Decimal $other)
    {
        $greatestScale = $this->maxScale($other);
        return (0 == bccomp($this->value, $other->value, $greatestScale));
    }

    /**
     * Unlike hasEqualValueTo, this method considers two Sj_Decimal objects equal only if they are equal in value and
     * scale (thus 2.0 is not equal to 2.00 when compared by this method).
     * @param Sj_Decimal $other
     * @return boolean
     */
    public function isEqualTo(Sj_Decimal $other)
    {
        return $this->hasEqualValueTo($other) && $this->scale == $other->scale;
    }

    /**
     * @return Sj_Decimal
     */
    public function abs()
    {
        if ($this->isLessThan(Sj_Decimal::valueOf(0))) {
            $value = bcsub(0, $this->value, $this->getScale());
        } else {
            $value = $this->value;
        }
        return $this->createDecimal($value, $this->scale);
    }

    /**
     * @param string $value
     * @return string
     */
    private function trimBcMathZeros($value)
    {
        $value = rtrim($value, '0');
        $value = rtrim($value, '.');
        return $value;
    }

    /**
     * @param $value
     * @return integer|false
     */
    private function decimalSeparatorOffset($value)
    {
        return strpos($value, '.');
    }

    /**
     * @param Sj_Decimal $other
     * @return integer
     */
    private function maxScale(Sj_Decimal $other)
    {
        return max($this->getScale(), $other->getScale());
    }

    /**
     * @param double $value
     * @param integer $scale
     * @param Sj_Rounder_Rounder|null $rounder
     * @return double
     */
    private function roundValue($value, $scale, Sj_Rounder_Rounder $rounder = null)
    {
        if ($rounder == null) {
            $rounder = new Sj_Rounder_HalfUpRounder();
        }
        return $rounder->round($value, $scale);
    }

    /**
     * @return string
     */
    private function calcUnscaledValue()
    {
        return $this->calcPow($this->getScale());
    }

    /**
     * @param integer $n
     * @return string
     */
    private function calcPow($n)
    {
        return bcmul($this->value, bcpow(10, $n, self::MAX_SCALE), $this->getScale());
    }

    /**
     * @param string $value
     * @param integer $scale
     * @return Sj_Decimal
     */
    private function createDecimal($value, $scale)
    {
        return new self($value, $scale);
    }

    /**
     * @param $value
     * @return Sj_DecimalString
     */
    private static function createDecimalString($value)
    {
        return new Sj_DecimalString($value);
    }
}
