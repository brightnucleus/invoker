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

namespace BrightNucleus\Invoker\Tests\Fixtures;

class TestClass
{

    protected $argA;
    protected $argB;
    protected $argC;

    public function __construct($argA, $argB, $argC = null)
    {
        $this->argA = $argA;
        $this->argB = $argB;
        $this->argC = $argC;
    }

    public function get()
    {
        return [
            'argA' => $this->argA,
            'argB' => $this->argB,
            'argC' => $this->argC,
        ];
    }
}
