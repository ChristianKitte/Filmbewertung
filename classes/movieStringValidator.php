<?php
/**
 * Created by PhpStorm.
 * User: Christian Kitte
 * Date: 15.05.2017
 * Time: 12:32
 */

namespace classes;

// The files have to be available. Therefore use "require" instead of "include".
require_once __DIR__ . "/../constants.php";

/**
 * Class movieStringValidator a concrete validator for string attributes of movies. A string has to match its pattern.
 * @package classes
 */
class movieStringValidator implements IStringValidator
{
    /**
     * @var array Stores regulare expressions in relation to names (of fields).
     */
    protected $pattern = array();

    /**
     * movieStringValidator constructor.
     */
    public function __construct()
    {
        $this->pattern['title'] = "/" . VALIDATION_PATERN_TITLE . "/";
    }

    /**
     * Verifies a string.
     * @param string $value The string to be verified.
     * @param string $field The field for which the validation should take place.
     * @return bool True, if valid, otherwise false.
     */
    public function isValid(string $value, string $field): bool
    {
        if (empty($this->pattern[$field])) {
            return false;
        }

        $workText = trim($value);
        $workPattern = $this->pattern[$field];

        if (preg_match($workPattern, $workText)) {
            return true;
        } else {
            return false;
        }
    }
}