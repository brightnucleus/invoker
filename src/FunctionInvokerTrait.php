<?php
/**
 * FunctionInvokerTrait
 *
 * @package   BrightNucleus\Invoker
 * @author    Alain Schlesser <alain.schlesser@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.brightnucleus.com/
 * @copyright 2015-2016 Alain Schlesser, Bright Nucleus
 */

namespace BrightNucleus\Invoker;

use BrightNucleus\Exception\InvalidArgumentException;
use Exception;
use ReflectionFunction;

/**
 * Trait to make the invokeFunction() method easily accessible inside classes.
 *
 * @since   0.1.0
 *
 * @package BrightNucleus\Invoker
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
trait FunctionInvokerTrait
{

    /**
     * Check the accepted arguments for a given function and pass associative
     * array values in the right order.
     *
     * @since 0.1.0
     *
     * @param  string $function Name of the function to invoke.
     * @param  array  $args     Associative array that contains the arguments.
     * @return mixed            Return value of the invoked function.
     * @throws InvalidArgumentException If a valid function is missing.
     */
    public function invokeFunction($function, array $args = array())
    {

        if (! $function || ! is_string($function) || '' === $function) {
            throw new InvalidArgumentException(_('Missing valid function to invoke.'));
        }

        try {
            $reflection = new ReflectionFunction($function);
            $pass       = array();

            foreach ($reflection->getParameters() as $param) {
                if (array_key_exists($param->name, $args)) {
                    $pass[] = $args[$param->name];
                } else {
                    $pass[] = $param->getDefaultValue();
                }
            }

            return $reflection->invokeArgs($pass);
        } catch (Exception $exception) {
            throw new InvalidArgumentException(
                sprintf(
                    _('Failed to invoke function "%1$s". Reason: %2$s'),
                    $function,
                    $exception->getMessage()
                )
            );
        }
    }
}
