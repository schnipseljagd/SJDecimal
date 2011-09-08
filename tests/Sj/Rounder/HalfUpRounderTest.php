<?php
require_once 'src/Sj/Rounder/Rounder.php';
require_once 'src/Sj/Rounder/HalfUpRounder.php';

/**
 * @covers Sj_Rounder_HalfUpRounder
 */
class Sj_Rounder_HalfUpRounderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider valueProvider
     * @param float $rawValue
     * @param int $precision
     * @param int $expected
     */
    public function returnsDownRoundedValue($rawValue, $precision, $expected)
    {
        $rounder = new Sj_Rounder_HalfUpRounder();
        $roundedValue = $rounder->round($rawValue, $precision);
        $this->assertEquals($expected, $roundedValue);
    }

    public static function valueProvider()
    {
        /* raw, precision, expected */
        return array(
            array(1.1, 0, 1),
            array(9.9, 0, 10),
            array(1.1, 1, 1.1),
            array(9.9, 1, 9.9),
            array(1.11, 0, 1),
            array(9.99, 1, 10),
            array(1.11, 2, 1.11),
            array(9.999, 2, 10),
        );
    }
}
