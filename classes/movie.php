<?php
/**
 * Created by PhpStorm.
 * User: Christian Kitte
 * Date: 21.05.2017
 * Time: 13:07
 */

/*
The class Movie encapsulate a concrete movie and its properties. All serialization will be done through the
person object owning the movie object. Therefore there a not method to do this within this class.

All validation will be done by an IStringValidator and an INumberValidator. Both have to be given as
parameters at instanciation.
*/

namespace classes;

// The files have to be available. Therefore use "require" instead of "include".
require_once __DIR__ . "/IStringValidator.php";
require_once __DIR__ . "/INumberValidator.php";
require_once __DIR__ . "/movieStringValidator.php";
require_once __DIR__ . "/movieNumberValidator.php";

/**
 * Class movie The Class encapsulate a concrete movie and its properties.
 * @package classes
 */
class movie
{
    /**
     * @var IStringValidator|null The Validator for text.
     */
    protected $stringValidator = null;
    /**
     * @var INumberValidator|null The Validator for numbers.
     */
    protected $numberValidator = null;

    /**
     * @var int The ID
     */
    protected $id = -1;
    /**
     * @var string The title
     */
    protected $title = "";
    /**
     * @var int The year
     */
    protected $year = -1;
    /**
     * @var int The rating
     */
    protected $rating = -1;

    /**
     * Holds the state of title.
     * @var bool True, if valid, otherwise false.
     */
    protected $isValidTitle = false;
    /**
     * Holds the state of year.
     * @var bool True, if valid, otherwise false.
     */
    protected $isValidYear = false;
    /**
     * Holds the state of rating.
     * @var bool True, if valid, otherwise false.
     */
    protected $isValidRating = false;

    /**
     * movie constructor.
     * @param IStringValidator $stringValidator An IStringValidator for validating the attributes.
     * @param INumberValidator $numberValidator An INumberValidator for validating the attributes.
     */
    function __construct(IStringValidator $stringValidator, INumberValidator $numberValidator)
    {
        $this->stringValidator = $stringValidator;
        $this->numberValidator = $numberValidator;
    }

    /**
     * Returns true if the title is valid.
     * @return bool True, if valid, otherwise false.
     */
    public function isValidTitle(): bool
    {
        return $this->isValidTitle;
    }

    /**
     * Returns true if the year is valid.
     * @return bool True, if valid, otherwise false.
     */
    public function isValidYear(): bool
    {
        return $this->isValidYear;
    }

    /**
     * Returns true if the rating is valid.
     * @return bool True, if valid, otherwise false.
     */
    public function isValidRating(): bool
    {
        return $this->isValidRating;
    }

    /**
     * Returns the ID.
     * @return int The ID.
     */
    public function getID(): int
    {
        return $this->id;
    }

    /**
     * Sets the ID.
     * @param int $id The ID.
     */
    public function setID(int $id)
    {
        $this->id = $id;
    }

    /**
     * Returns the title.
     * @return string The title.
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Sets the title.
     * @param string $value The title
     * @return bool True, if successful, otherwise false.
     */
    public function setTitle(string $value): bool
    {
        if ($this->stringValidator->isValid($value, "title")) {
            $this->title = $value;
            $this->isValidTitle = true;
            return true;
        } else {
            $this->isValidTitle = false;
            return false;
        }
    }

    /**
     * Returns the year.
     * @return int The year.
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * Sets the year.
     * @param int $value The year.
     * @return bool True, if successful, otherwise false.
     */
    public function setYear(int $value): bool
    {
        if ($this->numberValidator->isValid($value, "year")) {
            $this->year = $value;
            $this->isValidYear = true;
            return true;
        } else {
            $this->isValidYear = false;
            return false;
        }
    }

    /**
     * Returns the rating.
     * @return int The rating.
     */
    public function getRating(): int
    {
        return $this->rating;
    }

    /**
     * Sets the rating.
     * @param int $value The rating.
     * @return bool True, if successful, otherwise false.
     */
    public function setRating(int $value): bool
    {
        if ($this->numberValidator->isValid($value, "rating")) {
            $this->rating = $value;
            $this->isValidRating = true;
            return true;
        } else {
            $this->isValidRating = false;
            return false;
        }
    }

    /**
     * The textual description of an concrete Person.
     * @return string The description
     */
    public function __toString(): string
    {
        return "$this->getTitle(), $this->getYear(), $this->getRating()";
    }

    /**
     * Return whether a person is valid or not.
     * @return bool True, if valid, otherwise false.
     */
    public function isValidMovie(): bool
    {
        return (!empty($this->getTitle()) && $this->getYear() > 0 && $this->getRating() > 0);
    }
}