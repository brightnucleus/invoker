<?php
/**
 * Bright Nucleus Invoker Component.
 *
 * @package   BrightNucleus\Invoker
 * @author    Alain Schlesser <alain.schlesser@gmail.com>
 * @license   MIT
 * @link      http://www.brightnucleus.com/
 * @copyright 2015-2016 Alain Schlesser, Bright Nucleus
 */

namespace BrightNucleus\Invoker;


use ReflectionFunction;

/**
 * Test function to test the order of the arguments as they are provided.
 *
 * @param string      $argA First argument passed.
 * @param string      $argB Second argument passed.
 * @param string|null $argC Optional. Third argument passed.
 * @return array Associative array that is returned to check the result.
 */
function helperFunction($argA, $argB, $argC = null)
{
    return [
        'argA' => $argA,
        'argB' => $argB,
        'argC' => $argC,
    ];
}

/**
 * Class HelperTest.
 *
 * @since   0.1.0
 *
 * @package BrightNucleus\Exception
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
class HelperTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test several combinations of the parseParams() static method.
     *
     * @dataProvider provideTestParseParamsData
     *
     * @covers       \BrightNucleus\Invoker\Helper::parseParams
     *
     * @param array $array    Associative array containing the arguments in an arbitrary order.
     * @param array $expected Associative array with the expected result of the dumpFunction() call.
     */
    public function testParseParams(array $array, $expected)
    {
        $reflection = new ReflectionFunction('BrightNucleus\Invoker\helperFunction');
        $result     = Helper::parseParams($reflection->getParameters(), $array);
        $this->assertEquals($expected, $result);
    }

    /**
     * Provide data to the testParseParams() method.
     *
     * @return array
     */
    public function provideTestParseParamsData()
    {
        return [
            [
                ['argA' => 'valA', 'argB' => 'valB', 'argC' => 'valC'],
                ['valA', 'valB', 'valC'],
            ],
            [
                ['argB' => 'valA', 'argC' => 'valB', 'argA' => 'valC'],
                ['valC', 'valA', 'valB'],
            ],
            [
                ['argC' => 'valA', 'argA' => 'valB', 'argB' => 'valC'],
                ['valB', 'valC', 'valA'],
            ],
            [
                ['argA' => 'valA', 'argB' => 'valB', 'argC' => 'valC', 'argD' => 'valD'],
                ['valA', 'valB', 'valC'],
            ],
            [
                ['argZ' => 'valZ', 'argA' => 'valA', 'argB' => 'valB', 'argC' => 'valC', 'argD' => 'valD'],
                ['valA', 'valB', 'valC'],
            ],
            [
                ['argA' => 'valA', 'argB' => 'valB'],
                ['valA', 'valB', null],
            ],
            [
                ['argB' => 'valA', 'argA' => 'valC'],
                ['valC', 'valA', null],
            ],
            [
                ['argA' => 'valA', 'argB' => 'valB', 'argD' => 'valD'],
                ['valA', 'valB', null],
            ],
        ];
    }

    /**
     * Make sure it throws an exception if no arguments are passed.
     *
     * @covers \BrightNucleus\Invoker\Helper::parseParams
     */
    public function testParseParamsThrowsExceptionOnMissingArguments()
    {
        $array      = [];
        $reflection = new ReflectionFunction('BrightNucleus\Invoker\helperFunction');
        $this->setExpectedException(
            'ReflectionException',
            'Internal error: Failed to retrieve the default value'
        );
        Helper::parseParams($reflection->getParameters(), $array);
    }

    /**
     * Make sure it throws an exception if wrong arguments are passed.
     *
     * @covers \BrightNucleus\Invoker\Helper::parseParams
     */
    public function testParseParamsThrowsExceptionOnWrongArguments()
    {
        $array      = ['argNonSense' => 'Nonsense'];
        $reflection = new ReflectionFunction('BrightNucleus\Invoker\helperFunction');
        $this->setExpectedException(
            'ReflectionException',
            'Internal error: Failed to retrieve the default value'
        );
        Helper::parseParams($reflection->getParameters(), $array);
    }
}
