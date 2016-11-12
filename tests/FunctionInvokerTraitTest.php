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

/**
 * Test function to test the order of the arguments as they are provided.
 *
 * @param string      $argA First argument passed.
 * @param string      $argB Second argument passed.
 * @param string|null $argC Optional. Third argument passed.
 * @return array Associative array that is returned to check the result.
 */
function dumpFunction($argA, $argB, $argC = null)
{
    return [
        'argA' => $argA,
        'argB' => $argB,
        'argC' => $argC,
    ];
}

/**
 * Class FunctionInvokerTraitTest.
 *
 * @since   0.1.0
 *
 * @package BrightNucleus\Exception
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
class FunctionInvokerTraitTest extends \PHPUnit_Framework_TestCase
{

    use FunctionInvokerTrait;

    /**
     * Test several combinations of the invokeFunction() method.
     *
     * @dataProvider provideTestInvokeFunctionData
     *
     * @covers       \BrightNucleus\Invoker\FunctionInvokerTrait::invokeFunction
     *
     * @param array $array    Associative array containing the arguments in an arbitrary order.
     * @param array $expected Associative array with the expected result of the dumpFunction() call.
     */
    public function testInvokeFunction(array $array, $expected)
    {
        $result = $this->invokeFunction('BrightNucleus\Invoker\dumpFunction', $array);
        $this->assertEquals($expected, $result);
    }

    /**
     * Provide data to the testInvokeFunction() method.
     *
     * @return array
     */
    public function provideTestInvokeFunctionData()
    {
        return [
            [
                ['argA' => 'valA', 'argB' => 'valB', 'argC' => 'valC'],
                ['argA' => 'valA', 'argB' => 'valB', 'argC' => 'valC'],
            ],
            [
                ['argB' => 'valA', 'argC' => 'valB', 'argA' => 'valC'],
                ['argA' => 'valC', 'argB' => 'valA', 'argC' => 'valB'],
            ],
            [
                ['argC' => 'valA', 'argA' => 'valB', 'argB' => 'valC'],
                ['argA' => 'valB', 'argB' => 'valC', 'argC' => 'valA'],
            ],
            [
                ['argA' => 'valA', 'argB' => 'valB', 'argC' => 'valC', 'argD' => 'valD'],
                ['argA' => 'valA', 'argB' => 'valB', 'argC' => 'valC'],
            ],
            [
                ['argZ' => 'valZ', 'argA' => 'valA', 'argB' => 'valB', 'argC' => 'valC', 'argD' => 'valD'],
                ['argA' => 'valA', 'argB' => 'valB', 'argC' => 'valC'],
            ],
            [
                ['argA' => 'valA', 'argB' => 'valB'],
                ['argA' => 'valA', 'argB' => 'valB', 'argC' => null],
            ],
            [
                ['argB' => 'valA', 'argA' => 'valC'],
                ['argA' => 'valC', 'argB' => 'valA', 'argC' => null],
            ],
            [
                ['argA' => 'valA', 'argB' => 'valB', 'argD' => 'valD'],
                ['argA' => 'valA', 'argB' => 'valB', 'argC' => null],
            ],
        ];
    }

    /**
     * Make sure it throws an exception if the function is missing.
     *
     * @covers \BrightNucleus\Invoker\FunctionInvokerTrait::invokeFunction
     */
    public function testInvokeFunctionThrowsExceptionOnMissingFunction()
    {
        $array = ['argA' => 'valA', 'argX' => 'valX', 'argY' => 'valY', 'argZ' => 'valZ'];
        $this->setExpectedException(
            'BrightNucleus\Exception\InvalidArgumentException',
            'Missing valid function to invoke.'
        );
        $this->invokeFunction(null, $array);
    }

    /**
     * Make sure it throws an exception if the function is not valid.
     *
     * @covers \BrightNucleus\Invoker\FunctionInvokerTrait::invokeFunction
     */
    public function testInvokeFunctionThrowsExceptionOnInvalidFunction()
    {
        $array = ['argA' => 'valA', 'argX' => 'valX', 'argY' => 'valY', 'argZ' => 'valZ'];
        $this->setExpectedException(
            'BrightNucleus\Exception\InvalidArgumentException',
            'Missing valid function to invoke.'
        );
        $this->invokeFunction(25, $array);
    }

    /**
     * Make sure it throws an exception if the function does not exist.
     *
     * @covers \BrightNucleus\Invoker\FunctionInvokerTrait::invokeFunction
     */
    public function testInvokeFunctionThrowsExceptionOnUnknownFunction()
    {
        $array = ['argA' => 'valA', 'argX' => 'valX', 'argY' => 'valY', 'argZ' => 'valZ'];
        $this->setExpectedException(
            'BrightNucleus\Exception\InvalidArgumentException',
            'Failed to invoke function "unknownFunction".'
        );
        $this->invokeFunction('unknownFunction', $array);
    }

    /**
     * Make sure it throws an exception if an argument is missing.
     *
     * @covers \BrightNucleus\Invoker\FunctionInvokerTrait::invokeFunction
     */
    public function testInvokeFunctionThrowsException()
    {
        $array = ['argA' => 'valA', 'argX' => 'valX', 'argY' => 'valY', 'argZ' => 'valZ'];
        $this->setExpectedException(
            'BrightNucleus\Exception\InvalidArgumentException',
            'Failed to invoke function "BrightNucleus\Invoker\dumpFunction".'
        );
        $this->invokeFunction('BrightNucleus\Invoker\dumpFunction', $array);
    }
}
