<?php
require_once 'src/Sj/DecimalString.php';

class Sj_DecimalStringTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldReturnScale()
    {
        $decimalString = new Sj_DecimalString('23.5430');
        $this->assertEquals(3, $decimalString->getScale());
    }

    /**
     * @test
     */
    public function itShouldReturnScaleZero()
    {
        $decimalString = new Sj_DecimalString('23');
        $this->assertEquals(0, $decimalString->getScale());
    }

    /**
     * @test
     */
    public function itShouldReturnScaleOfTheFloatingPoint()
    {
        $decimalString = new Sj_DecimalString('12.23.543');
        $this->assertEquals(3, $decimalString->getScale());
    }

    public function noneDecimalStrings()
    {
        return array(
            array('12.23.543'),
            array('hallo.234'),
            array('a23'),
        );
    }

    /**
     * @test
     * @dataProvider noneDecimalStrings
     * @param $value
     */
    public function itShouldNotBeADecimalString($value)
    {
        $decimalString = new Sj_DecimalString($value);
        $this->assertFalse($decimalString->isValid());
    }

    public function decimalStrings()
    {
        return array(
            array('12.343'),
            array('23'),
        );
    }

    /**
     * @test
     * @dataProvider decimalStrings
     * @param string $value
     */
    public function itShouldBeADecimalString($value)
    {
        $decimalString = new Sj_DecimalString($value);
        $this->assertTrue($decimalString->isValid());
    }
}
