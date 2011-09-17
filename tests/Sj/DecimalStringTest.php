<?php
/**
 * @covers Sj_DecimalString
 */
class Sj_DecimalStringTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldReturnScale()
    {
        $decimalString = new Sj_DecimalString('23.5430');
        $this->assertEquals(4, $decimalString->getScale());
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
     * @expectedException InvalidArgumentException
     * @param $value
     */
    public function itShouldNotBeADecimalString($value)
    {
        Sj_DecimalString::assertNumerical($value);
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
        Sj_DecimalString::assertNumerical($value);
        $this->assertTrue(true);
    }
}
