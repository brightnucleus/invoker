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

use BrightNucleus\Exception\RuntimeException;
use ReflectionParameter;

/**
 * Helper class that provides a function to parse and reorder parameters.
 *
 * @since   0.1.5
 *
 * @package BrightNucleus\Invoker
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
class Helper
{

    /**
     *
     *
     * @since 0.1.0
     *
     * @param ReflectionParameter[] $params The reflection parameters to parse.
     * @param array                 $args   The arguments to check against.
     * @return array The correctly ordered arguments to pass to the reflected callable.
     * @throws RuntimeException If a $param does not have a name() method.
     */
    public static function parseParams(array $params, $args)
    {
        $ordered_args = array();

        foreach ($params as $param) {
            if (! $param instanceof ReflectionParameter) {
                throw new RuntimeException(
                    sprintf(
                        _('Parameter %1$s is not an instance of ReflectionParameter.'),
                        $param
                    )
                );
            }
            $ordered_args[] = array_key_exists($param->name, $args)
                ? $args[$param->name]
                : $param->getDefaultValue();
        }

        return $ordered_args;
    }
}
