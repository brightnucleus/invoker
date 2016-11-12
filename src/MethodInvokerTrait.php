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

use BrightNucleus\Exception\InvalidArgumentException;
use Exception;
use ReflectionMethod;

/**
 * Trait to make the invokeMethod() method easily accessible inside classes.
 *
 * @since   0.1.0
 *
 * @package BrightNucleus\Invoker
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
trait MethodInvokerTrait
{

    /**
     * Check the accepted arguments for a given method and pass associative
     * array values in the right order.
     *
     * @since 0.1.0
     *
     * @param  object $object The object that contains the method to invoke.
     * @param  string $method Name of the method to invoke.
     * @param  array  $args   Associative array that contains the arguments.
     * @return mixed          Return value of the invoked method.
     * @throws InvalidArgumentException If a valid method is missing.
     */
    protected function invokeMethod($object, $method, array $args = [])
    {

        if (! $method || ! is_string($method) || '' === $method) {
            throw new InvalidArgumentException(_('Missing valid method to invoke.'));
        }

        try {
            $reflection        = new ReflectionMethod(get_class($object), $method);
            $ordered_arguments = Helper::parseParams(
                $reflection->getParameters(),
                $args
            );

            return $reflection->invokeArgs($object, $ordered_arguments);
        } catch (Exception $exception) {
            throw new InvalidArgumentException(
                sprintf(
                    _('Failed to invoke method "%1$s" of class "%2$s". Reason: %3$s'),
                    $method,
                    get_class($object),
                    $exception->getMessage()
                )
            );
        }
    }
}
