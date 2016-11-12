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
 * Class MethodInvokerTraitTest.
 *
 * @since   0.1.0
 *
 * @package BrightNucleus\Exception
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
class MethodInvokerTraitTest extends \PHPUnit_Framework_TestCase
{

    use MethodInvokerTrait;

    /**
     * Test method to test the order of the arguments as they are provided.
     *
     * @param string      $argA First argument passed.
     * @param string      $argB Second argument passed.
     * @param string|null $argC Optional. Third argument passed.
     * @return array Associative array that is returned to check the result.
     */
    public function dumpMethod($argA, $argB, $argC = null)
    {
        return [
            'argA' => $argA,
            'argB' => $argB,
            'argC' => $argC,
        ];
    }

    /**
     * Test several combinations of the invokeMethod() method.
     *
     * @dataProvider provideTestInvokeMethodData
     *
     * @covers       \BrightNucleus\Invoker\MethodInvokerTrait::invokeMethod
     *
     * @param array $array    Associative array containing the arguments in an arbitrary order.
     * @param array $expected Associative array with the expected result of the dumpMethod() call.
     */
    public function testInvokeMethod(array $array, $expected)
    {
        $result = $this->invokeMethod($this, 'dumpMethod', $array);
        $this->assertEquals($expected, $result);
    }

    /**
     * Provide data to the testInvokeMethod() method.
     *
     * @return array
     */
    public function provideTestInvokeMethodData()
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
     * Make sure it throws an exception if the method is missing.
     *
     * @covers \BrightNucleus\Invoker\MethodInvokerTrait::invokeMethod
     */
    public function testInvokeMethodThrowsExceptionOnMissingMethod()
    {
        $array = ['argA' => 'valA', 'argX' => 'valX', 'argY' => 'valY', 'argZ' => 'valZ'];
        $this->setExpectedException(
            'BrightNucleus\Exception\InvalidArgumentException',
            'Missing valid method to invoke.'
        );
        $this->invokeMethod($this, null, $array);
    }

    /**
     * Make sure it throws an exception if the method is not valid.
     *
     * @covers \BrightNucleus\Invoker\MethodInvokerTrait::invokeMethod
     */
    public function testInvokeMethodThrowsExceptionOnInvalidMethod()
    {
        $array = ['argA' => 'valA', 'argX' => 'valX', 'argY' => 'valY', 'argZ' => 'valZ'];
        $this->setExpectedException(
            'BrightNucleus\Exception\InvalidArgumentException',
            'Missing valid method to invoke.'
        );
        $this->invokeMethod($this, 25, $array);
    }

    /**
     * Make sure it throws an exception if the method does not exist.
     *
     * @covers \BrightNucleus\Invoker\MethodInvokerTrait::invokeMethod
     */
    public function testInvokeMethodThrowsExceptionOnUnknownMethod()
    {
        $array = ['argA' => 'valA', 'argX' => 'valX', 'argY' => 'valY', 'argZ' => 'valZ'];
        $this->setExpectedException(
            'BrightNucleus\Exception\InvalidArgumentException',
            'Failed to invoke method "unknownMethod" of class "BrightNucleus\Invoker\MethodInvokerTraitTest".'
        );
        $this->invokeMethod($this, 'unknownMethod', $array);
    }

    /**
     * Make sure it throws an exception if an argument is missing.
     *
     * @covers \BrightNucleus\Invoker\MethodInvokerTrait::invokeMethod
     */
    public function testInvokeMethodThrowsExceptionOnMissingArgument()
    {
        $array = ['argA' => 'valA', 'argX' => 'valX', 'argY' => 'valY', 'argZ' => 'valZ'];
        $this->setExpectedException(
            'BrightNucleus\Exception\InvalidArgumentException',
            'Failed to invoke method "dumpMethod" of class "BrightNucleus\Invoker\MethodInvokerTraitTest".'
        );
        $this->invokeMethod($this, 'dumpMethod', $array);
    }
}
