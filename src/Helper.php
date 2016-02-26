<?php
/**
 * Invoker Helper.
 *
 * @package   BrightNucleus\Invoker
 * @author    Alain Schlesser <alain.schlesser@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.brightnucleus.com/
 * @copyright 2015-2016 Alain Schlesser, Bright Nucleus
 */

namespace BrightNucleus\Invoker;

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
     */
    public static function parse_params(array $params, $args)
    {
        $ordered_args = array();

        foreach ($params as $param) {
            $ordered_args[] = array_key_exists($param->name, $args)
                ? $args[$param->name]
                : $param->getDefaultValue();
        }

        return $ordered_args;
    }
}
