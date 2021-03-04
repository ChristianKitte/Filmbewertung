<?php
/**
 * Created by PhpStorm.
 * User: Christian Kitte
 * Date: 15.05.2017
 * Time: 12:34
 */

namespace classes;

/**
 * Interface IStringValidator Provides a service for validating a string in relation to a field.
 * @package classes
 */
interface IStringValidator
{
    /**
     * Verifies a string
     * @param string $valuec
     * @param string $field The field for which the validation should take place.
     * @return bool True, if valid, otherwise false.
     */
    public function isValid(string $value, string $field): bool;
}