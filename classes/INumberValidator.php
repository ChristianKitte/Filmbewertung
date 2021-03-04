<?php
/**
 * Created by PhpStorm.
 * User: Christian Kitte
 * Date: 15.05.2017
 * Time: 12:34
 */

namespace classes;

/**
 * Interface INumberValidator Provides a service for validating a number in relation to a field.
 * @package classes
 */
interface INumberValidator
{
    /**
     * Verifies a number.
     * @param int $value The number to be verified.
     * @param string $field The field for which the validation should take place.
     * @return bool True, if valid, otherwise false.
     */
    public function isValid(int $value, string $field): bool;
}