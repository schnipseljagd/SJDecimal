<?php
 
class Sj_DecimalString
{
    /**
     * @var string
     */
    private $value;

    /**
     * @param string $value
     */
    public function __construct($value)
    {
        $this->value = (string)$value;
    }

    /**
     * @return integer
     */
    public function getScale()
    {
        $hit = strrpos($this->value, '.');
        if ($hit === false) {
            return 0;
        } else {
            return strlen($this->value) - $hit - 1;
        }
    }

    /**
     * @throws InvalidArgumentException
     * @param $value
     */
    public static function assertNumerical($value)
    {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException('string is not numerical.');
        }
    }
}
