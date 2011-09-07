<?php

class Sj_Decimal
{
    /**
     * @var string
     */
    private $value;
    /**
     * @var integer
     */
    private $scale;

    /**
     * @param string $value
     * @param integer|null $scale
     */
    public function __construct($value, $scale = null)
    {
        $this->scale = (int)$scale;
        $this->value = bcadd((string)$value, 0, $this->scale);
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
            if (!$decimalString->isValid()) {
                throw new InvalidArgumentException('string is not numeric.');
            }
            return new self($value, $decimalString->getScale());
        }
        throw new InvalidArgumentException('value is not of an expected type.');
    }

    /**
     * @param integer $unscaledValue
     * @param integer $scale
     * @return Sj_Decimal
     */
    public static function valueOfUnscaledValueAndScale($unscaledValue, $scale)
    {
        return new self((int) $unscaledValue, -(int)$scale);
    }

    /**
     * @param Sj_Decimal $multiplicand
     * @return Sj_Decimal
     */
    public function multiply(Sj_Decimal $multiplicand)
    {
        $newScale = $this->getScale() + $multiplicand->getScale();
        $result = bcmul($this->value, $multiplicand->value, $newScale);
        return self::valueOf($result);
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
    public function getUnscaledValue()
    {
        return $this->calcUnscaledValue();
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
     * @return bool
     */
    private function isNegativeScale()
    {
        return $this->scale < 0;
    }

    /**
     * @param integer $n
     * @return Sj_Decimal
     */
    public function pow($n)
    {
        $n = (int) $n;
        return $this->createDecimal($this->calcPow($n), -$n);
    }

    /**
     * @return integer
     */
    public function getPrecision()
    {
        return strlen($this->getUnscaledValue());
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
        return bcmul($this->value, bcpow(10, abs($n)));
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
