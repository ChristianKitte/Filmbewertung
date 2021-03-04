<?php
/**
 * Created by PhpStorm.
 * User: Christian Kitte
 * Date: 15.05.2017
 * Time: 12:32
 */

namespace classes;

/**
 * Class movieNumberValidator a concrete validator for number attributes of movies. A number has to be between a
 * minimum and maximum which is defined within the class in relation to a field.
 * @package classes
 */
class movieNumberValidator implements INumberValidator
{
    /**
     * @var array Stores the min value in relation to names (of fields)
     */
    protected $min = array();
    /**
     * @var array Stores the max value in relation to names (of fields)
     */
    protected $max = array();

    /**
     * movieNumberValidator constructor.
     */
    public function __construct()
    {
        $this->min['year'] = MINYEAR;
        $this->max['year'] = date("Y");
        $this->min['rating'] = MINNUMBER_POINT;
        $this->max['rating'] = MAXNUMBER_POINT;
    }

    /**
     * Verifies a number.
     * @param int $value The number to be verified.
     * @param string $field The field for which the validation should take place.
     * @return bool True, if valid, otherwise false.
     */
    public function isValid(int $value, string $field): bool
    {
        if (empty($this->min[$field]) || empty($this->max[$field])) {
            return false;
        }

        $minValue = $this->min[$field];
        $maxValue = $this->max[$field];

        if ($value >= $minValue && $value <= $maxValue) {
            return true;
        } else {
            return false;
        }
    }
}
