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
use ReflectionClass;

/**
 * Trait to make the instantiate() method easily accessible inside classes.
 *
 * @since   0.2.0
 *
 * @package BrightNucleus\Invoker
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
trait InstantiatorTrait
{

    /**
     * Check the accepted arguments for a given class constructor and pass
     * associative array values in the right order.
     *
     * @since 0.2.0
     *
     * @param  string $class The class that needs to be instantiated.
     * @param  array  $args  Associative array that contains the arguments.
     *
     * @return object        Instantiated object.
     * @throws InvalidArgumentException If a valid method is missing.
     */
    protected function instantiateClass($class, array $args)
    {
        try {
            $reflectionMethod = new ReflectionMethod($class, '__construct');

            $ordered_arguments = Helper::parseParams(
                $reflectionMethod->getParameters(),
                $args
            );

            $reflectionClass = new ReflectionClass($class);

            return $reflectionClass->newInstanceArgs(
                (array)$ordered_arguments
            );
        } catch (Exception $exception) {
            throw new InvalidArgumentException(
                sprintf(
                    _('Failed to instantiate class "%1$s". Reason: %2$s'),
                    $class,
                    $exception->getMessage()
                )
            );
        }
    }
}
