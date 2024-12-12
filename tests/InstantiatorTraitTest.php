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

namespace BrightNucleus\Invoker\Tests;

use BrightNucleus\Exception\InvalidArgumentException;
use BrightNucleus\Invoker\InstantiatorTrait;

/**
 * Class InstantiatorTraitTest.
 *
 * @since   0.2.0
 *
 * @package BrightNucleus\Exception
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
class InstantiatorTraitTest extends TestCase
{

    use InstantiatorTrait;

    /**
     * Test several combinations of the instantiateClass() method.
     *
     * @dataProvider provideTestInstantiateClassMethodData
     *
     * @covers       \BrightNucleus\Invoker\InstantiatorTrait::instantiateClass
     *
     * @param array $array    Associative array containing the arguments in an arbitrary order.
     * @param array $expected Associative array with the expected result of the dumpMethod() call.
     */
    public function testInstantiateClassMethod(array $array, $expected)
    {
        $result = $this->instantiateClass(Fixtures\TestClass::class, $array);
        $this->assertEquals($expected, $result->get());
    }

    /**
     * Provide data to the testInstantiateClassMethod() method.
     *
     * @return array
     */
    public function provideTestInstantiateClassMethodData()
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
     * Make sure it throws an exception if an argument is missing.
     *
     * @covers \BrightNucleus\Invoker\InstantiatorTrait::instantiateClass
     */
    public function testInstantiateClassMethodThrowsExceptionOnMissingArgument()
    {
        $array = ['argA' => 'valA', 'argX' => 'valX', 'argY' => 'valY', 'argZ' => 'valZ'];
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Failed to instantiate class "BrightNucleus\Invoker\Tests\Fixtures\TestClass"');
        $this->instantiateClass(Fixtures\TestClass::class, $array);
    }
}
