<?php
/**
 * @covers Sj_Rounder_HalfUpRounder
 */
class Sj_Rounder_HalfUpRounderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Sj_Rounder_HalfUpRounder
     */
    private $rounder;

    public function setUp()
    {
        $this->rounder = new Sj_Rounder_HalfUpRounder();
    }

    public function valuesToRoundDown()
    {
        /* raw, precision, expected */
        return array(
            array('1.1', 0, '1'),
            array('1.1', 1, '1.1'),
            array('1.11', 0, '1'),
            array('1.11', 2, '1.11'),
            array('123456.7456713', 6, '123456.745671'),
        );
    }

    /**
     * @test
     * @dataProvider valuesToRoundDown
     * @param float $rawValue
     * @param int $precision
     * @param int $expected
     */
    public function returnsDownRoundedValue($rawValue, $precision, $expected)
    {
        $roundedValue = $this->rounder->round($rawValue, $precision);
        $this->assertEquals($expected, $roundedValue);
    }

    /**
     * @return array
     */
    public function valuesToRoundUp()
    {
        /* raw, precision, expected */
        return array(
            array('9.9', 0, '10'),
            array('9.9', 1, '9.9'),
            array('9.99', 1, '10'),
            array('9.999', 2, '10'),
            array('123456.7456715', 6, '123456.745672'),
            array('0.1666666666666665', 13, '0.1666666666667')
        );
    }

    /**
     * @test
     * @dataProvider valuesToRoundUp
     * @param float $rawValue
     * @param int $precision
     * @param int $expected
     */
    public function returnsUpRoundedValue($rawValue, $precision, $expected)
    {
        $roundedValue = $this->rounder->round($rawValue, $precision);
        $this->assertEquals($expected, $roundedValue);
    }

    /**
     * @test
     * @dataProvider periodProvider
     * @param string $valueToRound
     * @param integer $scale
     * @param string $expectedValue
     */
    public function roundPeriods($valueToRound, $scale, $expectedValue)
    {
        $roundedValue = $this->rounder->round($valueToRound, $scale);
        $this->assertEquals($expectedValue, $roundedValue);
    }

    /**
     * @return array
     */
    public function periodProvider()
    {
        return array(
            array('2.66666666666666', 13, '2.6666666666667'),
            array('3.05757575757575757575', 13, '3.0575757575758'),
        );
    }
}
