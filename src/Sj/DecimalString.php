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
        $value = rtrim($this->value, '0');
        $hit = strrpos($value, '.');
        if ($hit === false) {
            return 0;
        } else {
            return strlen($value) - $hit - 1;
        }
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return is_numeric($this->value);
    }
}
