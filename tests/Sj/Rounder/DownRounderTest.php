<?php
/**
 * @covers Sj_Rounder_DownRounder
 */
class Sj_Rounder_DownRounderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider valueProvider
     * @param string $rawValue
     * @param int $scale
     * @param string $expected
     */
    public function returnsDownRoundedValue($rawValue, $scale, $expected)
    {
        $rounder = new Sj_Rounder_DownRounder();
        $roundedValue = $rounder->round($rawValue, $scale);
        $this->assertEquals($expected, $roundedValue);
    }

    public static function valueProvider()
    {
        /* raw, scale, expected */
        return array(
            array('1.1', 0, '1'),
            array('9.9', 0, '9'),
            array('1.1', 1, '1.1'),
            array('9.9', 1, '9.9'),
            array('1.11', 0, '1'),
            array('9.99', 0, '9'),
            array('1.11', 1, '1.1'),
            array('9.99', 1, '9.9'),
        );
    }
}
