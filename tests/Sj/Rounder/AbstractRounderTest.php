<?php
/**
 * @covers Sj_Rounder_AbstractRounder
 */
class Sj_Rounder_AbstractRounderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Sj_Rounder_AbstractRounder
     */
    private $rounder;

    public function setUp()
    {
        $this->rounder = $this->getMockForAbstractClass('Sj_Rounder_AbstractRounder');
    }

    /**
     * DataProvider
     * @return array
     */
    public function byPowerOfTenData()
    {
        return array(
            array('0.05', 3, '50', 2),
            array('5', 0, '5', 0),
            array('5', 2, '500', 0),
            array('5', 12, '5000000000000', 0),
            array('1200000', 0, '1200000', 0),
        );
    }

    /**
     * @test
     * @dataProvider byPowerOfTenData
     * @param string $val
     * @param int $steps
     * @param string $product
     * @param int $scale
     *
     */
    public function shiftPointRight($val, $steps, $product, $scale)
    {
        $this->assertEquals($product, $this->rounder->shiftPointRight($val, $steps, $scale));
    }

    /**
     * @test
     * @dataProvider byPowerOfTenData
     * @param string $val
     * @param int $steps
     * @param string $product
     * @param int $scale
     */
    public function shiftPointLeft($val, $steps, $product, $scale)
    {
        $this->assertEquals($val, $this->rounder->shiftPointLeft($product, $steps, $scale));
    }

    /**
     * DataProvider
     * @return array
     */
    public function extractDecimalDataProvider()
    {
        return array(
            array('0.05', '0.05', 2),
            array('503.123456', '0.123456', 6),
            array('5', '0', 0),
            array('5000000000000', '0', 0),
        );
    }

    /**
     * @test
     * @dataProvider extractDecimalDataProvider
     * @param string $val
     * @param string $decimalPart
     * @param int $scale
     */
    public function extractDecimalPart($val, $decimalPart, $scale)
    {
        $this->assertEquals($decimalPart, $this->rounder->extractDecimalPart($val, $scale));
    }

    /**
     * DataProvider
     * @return array
     */
    public function extractIntegerDataProvider()
    {
        return array(
            array('0.05', '0'),
            array('503.123456', '503'),
            array('5', '5'),
            array('5000000000000', '5000000000000'),
        );
    }

    /**
     * @test
     * @dataProvider extractIntegerDataProvider
     * @param string $val
     * @param string $intPart
     */
    public function extractIntegerPart($val, $intPart)
    {
        $this->assertEquals($intPart, $this->rounder->extractIntegerPart($val));
    }
}
