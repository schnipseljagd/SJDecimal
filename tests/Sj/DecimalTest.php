<?php
/**
 * @covers Sj_Decimal
 */
class Sj_DecimalTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function itShouldMustBeNumerical()
    {
        new Sj_Decimal('test');
    }

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
        $this->assertEquals(2343, $decimal->getUnscaledValue());
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
    public function itShouldNotCreateByValueOfIfValueIsNotOfAnExpectedType()
    {
        Sj_Decimal::valueOf(true);
    }

    /**
     * @test
     */
    public function itShouldAddWithOtherDecimal()
    {
        $decimal = Sj_Decimal::valueOf(2.33);
        $this->assertEquals(
            Sj_Decimal::valueOf(6.43),
            $decimal->add(Sj_Decimal::valueOf(4.1))
        );
    }

    /**
     * @test
     */
    public function itShouldAddWithDifferentScales()
    {
        $decimal = Sj_Decimal::valueOf(2.33);
        $this->assertEquals(
            Sj_Decimal::valueOf(6.453),
            $decimal->add(Sj_Decimal::valueOf(4.123))
        );
    }

    /**
     * @test
     */
    public function itShouldSubtractWithOtherDecimal()
    {
        $decimal = Sj_Decimal::valueOf(6.43);
        $this->assertEquals(
            Sj_Decimal::valueOf(4.23),
            $decimal->subtract(Sj_Decimal::valueOf(2.2))
        );
    }

    /**
     * @test
     */
    public function itShouldSubtractWithDifferentScales()
    {
        $decimal = Sj_Decimal::valueOf(6.453);
        $this->assertEquals(
            Sj_Decimal::valueOf(4.123),
            $decimal->subtract(Sj_Decimal::valueOf(2.33))
        );
    }

    /**
     * @test
     */
    public function itShouldMultiplyWithOtherDecimal()
    {
        $decimal = Sj_Decimal::valueOf(10.06);
        $this->assertEquals(
            new Sj_Decimal('6.639600', 6),
            $decimal->multiply(new Sj_Decimal(0.66, 2))
        );
    }

    /**
     * @test
     */
    public function itShouldMultiplyAndBewareOfTrailingZeros()
    {
        $decimal = Sj_Decimal::valueOf(100);
        $this->assertEquals(
            new Sj_Decimal('33.333333', 6),
            $decimal->multiply(Sj_Decimal::valueOf(0.33333333))
        );
    }

    /**
     * @test
     */
    public function itShouldMultiplyWithPeriod()
    {
        $decimal = Sj_Decimal::valueOf(2);
        $this->assertEquals(
            new Sj_Decimal('0.666667', 6),
            $decimal->multiply(Sj_Decimal::valueOf(1/3))
        );
    }

    /**
     * @test
     */
    public function itShouldMultiplyWithDifferentScales()
    {
        $decimal = Sj_Decimal::valueOf(30.99);
        $this->assertEquals(
            new Sj_Decimal('92.966901', 6),
            $decimal->multiply(Sj_Decimal::valueOf(2.9999))
        );
    }

    /**
     * @test
     */
    public function itShouldMultiplyAndRound()
    {
        $decimal = Sj_Decimal::valueOf('0.333333');
        $this->assertEquals(
            Sj_Decimal::valueOf('0.166667'),
            $decimal->multiply(Sj_Decimal::valueOf(0.5))
        );
    }

    /**
     * @test
     */
    public function itShouldMultiplyWithMaxScale()
    {
        $decimal = Sj_Decimal::valueOf(10.0000000060000000006000000060000006);
        $this->assertEquals(
            Sj_Decimal::valueOf('33.333330'),
            $decimal->multiply(Sj_Decimal::valueOf(3.333333))
        );
    }

    /**
     * @test
     */
    public function itShouldDivideWithOtherDecimalValue()
    {
        $decimal = Sj_Decimal::valueOf(12);
        $this->assertEquals(
            new Sj_Decimal('4', 6),
            $decimal->divide(Sj_Decimal::valueOf(3))
        );
    }

    /**
     * @test
     */
    public function itShouldDivideWithPeriod()
    {
        $decimal = Sj_Decimal::valueOf(100);
        $this->assertEquals(
            new Sj_Decimal('30.000000', 6),
            $decimal->divide(Sj_Decimal::valueOf(10/3))
        );
    }

    /**
     * @test
     */
    public function itShouldDivideAndBewareOfTrailingZeros()
    {
        $decimal = Sj_Decimal::valueOf(100);
        $this->assertEquals(
            new Sj_Decimal('30.000030', 6),
            $decimal->divide(Sj_Decimal::valueOf(3.33333))
        );
    }

    /**
     * @test
     */
    public function itShouldDivideAndNotRound()
    {
        $decimal = Sj_Decimal::valueOf(10.09);
        $this->assertEquals(
            new Sj_Decimal('3.057576', 6),
            $decimal->divide(Sj_Decimal::valueOf(3.3))
        );
    }

    public function divisionValueProvider()
    {
        return array(
            array(0.2, 0.5, '0.400000', 6),
            array(5, 2, '2.500000', 6),
            array(8, 3, '2.666667', 6),
        );
    }

    /**
     * @dataProvider divisionValueProvider
     * @test
     * @param mixed $dividend
     * @param mixed $divisor
     * @param mixed $expectedValue
     * @param integer $expectedScale
     */
    public function itShouldDivideAndCalcScale($dividend, $divisor, $expectedValue, $expectedScale)
    {
        $decimal = Sj_Decimal::valueOf($dividend);
        $this->assertEquals(
            new Sj_Decimal($expectedValue, $expectedScale),
            $decimal->divide(Sj_Decimal::valueOf($divisor))
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
        $this->assertEquals(new Sj_Decimal(23500, 3), $decimal->pow(3));
    }

    /**
     * @test
     */
    public function itShouldReturnPrecision()
    {
        $decimal = Sj_Decimal::valueOf('23.5');
        $this->assertEquals(3, $decimal->getPrecision());
    }

    /**
     * @test
     */
    public function itShouldRoundHalfUpToScale()
    {
        $decimal = Sj_Decimal::valueOf('23.5');
        $this->assertEquals(24, $decimal->round(0)->doubleValue());
    }

    /**
     * @test
     */
    public function itShouldRoundWithDownRounder()
    {
        $decimal = Sj_Decimal::valueOf('23.23');
        $this->assertEquals(23.2, $decimal->round(1, new Sj_Rounder_DownRounder())->doubleValue());
    }

    /**
     * @test
     */
    public function itShouldCompareByGreaterThan()
    {
        $decimal = Sj_Decimal::valueOf('0.001');
        $this->assertTrue($decimal->isGreaterThan(Sj_Decimal::valueOf('0.0001')));
    }

    /**
     * @test
     */
    public function itShouldCompareByNotGreaterThan()
    {
        $decimal = Sj_Decimal::valueOf('0.001');
        $this->assertFalse($decimal->isGreaterThan(Sj_Decimal::valueOf('0.01')));
    }

    /**
     * @test
     */
    public function itShouldCompareByLessThan()
    {
        $decimal = Sj_Decimal::valueOf('0.001');
        $this->assertTrue($decimal->isLessThan(Sj_Decimal::valueOf('0.01')));
    }

    /**
     * @test
     */
    public function itShouldCompareByNotLessThan()
    {
        $decimal = Sj_Decimal::valueOf('0.01');
        $this->assertFalse($decimal->isLessThan(Sj_Decimal::valueOf('0.01')));
    }

    /**
     * @return array
     */
    public function valuesToCompareByEqualValueProvider()
    {
        return array(
            array('0.01', '0.01'),
            array('0.010', '0.01'),
            array('0.01', '0.010'),
            array('0.01000000', '0.01'),
        );
    }

    /**
     * @test
     * @dataProvider valuesToCompareByEqualValueProvider
     * @param $value
     * @param $otherValue
     */
    public function itShouldCompareByEqualValue($value, $otherValue)
    {
        $decimal = Sj_Decimal::valueOf($value);
        $this->assertTrue($decimal->hasEqualValueTo(Sj_Decimal::valueOf($otherValue)));
    }

    /**
     * @test
     */
    public function itShouldCompareByNotEqualValue()
    {
        $decimal = Sj_Decimal::valueOf('0.1');
        $this->assertFalse($decimal->hasEqualValueTo(Sj_Decimal::valueOf('0.101')));
    }

    /**
     * @test
     */
    public function itShouldCompareByEqual()
    {
        $decimal = Sj_Decimal::valueOf('0.01');
        $this->assertTrue($decimal->isEqualTo(Sj_Decimal::valueOf('0.01')));
    }

    /**
     * @test
     */
    public function itShouldCompareByNotEqual()
    {
        $decimal = new Sj_Decimal('0.01', 2);
        $this->assertFalse($decimal->isEqualTo(new Sj_Decimal('0.010', 3)));
    }

    /**
     * @test
     */
    public function itShouldConvertToAbsoluteValue()
    {
        $decimal = Sj_Decimal::valueOf('-0.1');
        $this->assertEquals(Sj_Decimal::valueOf('0.1'), $decimal->abs());
    }

    /**
     * @test
     */
    public function itShouldNotConvertToAbsoluteValue()
    {
        $decimal = Sj_Decimal::valueOf('0.1');
        $this->assertEquals(Sj_Decimal::valueOf('0.1'), $decimal->abs());
    }
}
