<?php
require_once 'src/Sj/Decimal.php';

class Sj_DecimalTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldHaveAStringValue()
    {
        $decimal = new Sj_Decimal(23.4, 1);
        $this->assertSame('23.4', $decimal->__toString());
    }

    /**
     * @test
     */
    public function itShouldHaveAScale()
    {
        $decimal = new Sj_Decimal('23.43', 2);
        $this->assertEquals(2, $decimal->getScale());
    }

    /**
     * @test
     */
    public function itShouldHaveANegativeScale()
    {
        $decimal = new Sj_Decimal('2343', -2);
        $this->assertEquals(-2, $decimal->getScale());
    }

    /**
     * @test
     */
    public function itShouldHaveAnUnscaledValue()
    {
        $decimal = new Sj_Decimal('2343', -2);
        $this->assertEquals(234300, $decimal->getUnscaledValue());
    }

    /**
     * @test
     */
    public function itShouldCreateByValueOfInteger()
    {
        $decimal = Sj_Decimal::valueOf(23);
        $this->assertSame('23', (string)$decimal);
    }

    /**
     * @test
     */
    public function itShouldCreateByValueOfIntegerAScaleOfZero()
    {
        $decimal = Sj_Decimal::valueOf(23);
        $this->assertSame(0, $decimal->getScale());
    }

    /**
     * @test
     */
    public function itShouldCreateByValueOfDouble()
    {
        $decimal = Sj_Decimal::valueOf(23.5432);
        $this->assertSame('23.5432', (string)$decimal);
    }

    /**
     * @test
     */
    public function itShouldCreateByValueOfDoubleAScaleOfTheNumberOfTheDigitsAfterTheFloatingPoint()
    {
        $decimal = Sj_Decimal::valueOf(23.5432);
        $this->assertSame(4, $decimal->getScale());
    }

    /**
     * @test
     */
    public function itShouldCreateByValueOfString()
    {
        $decimal = Sj_Decimal::valueOf('23.5432');
        $this->assertEquals('23.5432', (string)$decimal);
    }

    /**
     * @test
     */
    public function itShouldCreateByValueOfStringAScaleOfTheNumberOfTheDigitsAfterTheFloatingPoint()
    {
        $decimal = Sj_Decimal::valueOf('23.5432');
        $this->assertSame(4, $decimal->getScale());
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function itShouldNotCreateByValueOfStringIfNotNumeric()
    {
        Sj_Decimal::valueOf('test');
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function itShouldNotCreateByValueOfIfValueIsNotOfAnExpectedType()
    {
        Sj_Decimal::valueOf(true);
    }

    /**
     * @test
     */
    public function itShouldCreateByUnscaledValue()
    {
        $decimal = Sj_Decimal::valueOfUnscaledValueAndScale(235432, 4);
        $this->assertEquals('235432', (string)$decimal);
    }

    /**
     * @test
     */
    public function itShouldMultiplyWithOtherDecimal()
    {
        $decimal = Sj_Decimal::valueOf(30);
        $this->assertEquals(
            Sj_Decimal::valueOf(1.5),
            $decimal->multiply(Sj_Decimal::valueOf(0.05))
        );
    }

    /**
     * @test
     */
    public function itShouldMultiplyWithOtherDecimalWithAUnscaledValue()
    {
        $this->markTestSkipped('not implemented.');
        $decimal = Sj_Decimal::valueOf(30);
        $this->assertEquals(
            Sj_Decimal::valueOf(1.5),
            $decimal->multiply(Sj_Decimal::valueOfUnscaledValueAndScale(5, 2))
        );
    }

    /**
     * @test
     */
    public function itShouldReturnDoubleValue()
    {
        $decimal = Sj_Decimal::valueOf('23.5432');
        $this->assertEquals(23.5432, (string)$decimal->doubleValue());
    }

    /**
     * @test
     */
    public function itShouldReturnPow()
    {
        $decimal = Sj_Decimal::valueOf('23.5');
        $this->assertEquals(Sj_Decimal::valueOfUnscaledValueAndScale(23500, 3), $decimal->pow(3));
    }

    /**
     * @test
     */
    public function itShouldReturnPrecision()
    {
        $decimal = Sj_Decimal::valueOf('23.5');
        $this->assertEquals(3, $decimal->getPrecision());
    }
}
