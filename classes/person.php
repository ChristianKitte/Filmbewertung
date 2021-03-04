<?php
/**
 * Created by PhpStorm.
 * User: Christian Kitte
 * Date: 29.04.2017
 * Time: 20:20
 */

/*
The class Person encapsulate a concrete user and its properties. Its possible to serialize a Person through
an IStorage. It's also possible to retrieve a person from there. The IStorage has to be given as a parameter
at instanciation.

All validation will be done by an IStringValidator. The IStringValidator has to be given as a parameter at
instanciation.
*/

namespace classes;

// The files have to be available. Therefore use "require" instead of "include".
require_once __DIR__ . "/IStringValidator.php";
require_once __DIR__ . "/IStorage.php";
require_once __DIR__ . "/personStringValidator.php";
require_once __DIR__ . "/movie.php";

/**
 * Class person The class encapsulate a concrete user and its properties.
 * @package classes
 */
class person
{
    /**
     * @var IStorage|null The storage.
     */
    protected $storage = null;
    /**
     * @var IStringValidator|null The Validator for text.
     */
    protected $validator = null;

    /**
     * The ID.
     * @var int.
     */
    protected $id = -1;
    /**
     * The first name.
     * @var string.
     */
    protected $firstname = "";
    /**
     * The last name.
     * @var string.
     */
    protected $lastname = "";
    /**
     * The univerity.
     * @var string.
     */
    protected $university = "";
    /**
     * a movie collection.
     * @var array.
     */
    protected $movies = array();

    /**
     * Holds the state of first name.
     * @var bool True, if valid, otherwise false.
     */
    protected $isValidFirstname = false;
    /**
     * Holds the state of last name.
     * @var bool True, if valid, otherwise false.
     */
    protected $isValidLastname = false;
    /**
     * Holds the state of university.
     * @var bool True, if valid, otherwise false.
     */
    protected $isValidUniversity = false;

    /**
     * person constructor.
     * @param IStringValidator $validator An IStringValidator for validating the attributes.
     * @param IStorage $storage An IStorage to access the object.
     */
    public function __construct(IStringValidator $validator, IStorage $storage)
    {
        $this->storage = $storage;
        $this->validator = $validator;
    }

    /**
     * Returns true if the first name is valid.
     * @return bool
     */
    public function isValidFirstname(): bool
    {
        return $this->isValidFirstname;
    }

    /**
     * Returns true if the last name is valid.
     * @return bool True, if valid, otherwise false.
     */
    public function isValidLastname(): bool
    {
        return $this->isValidLastname;
    }

    /**
     * Returns true if the university is valid.
     * @return bool True, if valid, otherwise false.
     */
    public function isValidUniversity(): bool
    {
        return $this->isValidUniversity;
    }

    /**
     * Sets the ID.
     * @param int $value The ID.
     */
    public function setID(int $value)
    {
        $this->id = $value;
    }

    /**
     * Returns the uique ID.
     * @return int The ID.
     */
    public function getID(): int
    {
        return $this->id;
    }

    /**
     * Sets the first name. If not valid the value won't be inserted.
     * @param string $value The first name.
     * @return bool True, if valid, otherwise false.
     */
    public function setFirstname(string $value): bool
    {
        if ($this->validator->isValid($value, "firstname")) {
            $this->firstname = $value;
            $this->isValidFirstname = true;
            return true;
        } else {
            $this->isValidFirstname = false;
            return false;
        }
    }

    /**
     * Returns the first name.
     * @return string The first name.
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * Sets the last name. If not valid the value won't be inserted.
     * @param string $value The last name.
     * @return bool True, if valid, otherwise false.
     */
    public function setLastname(string $value): bool
    {
        if ($this->validator->isValid($value, "lastname")) {
            $this->lastname = $value;
            $this->isValidLastname = true;
            return true;
        } else {
            $this->isValidLastname = false;
            return false;
        }
    }

    /**
     * Returns the last name.
     * @return string The last name.
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * Sets the university. If not valid the value won't be inserted.
     * @param string $value The university.
     * @return bool True, if valid, otherwise false.
     */
    public function setUniversity(string $value): bool
    {
        if ($this->validator->isValid($value, "university")) {
            $this->university = $value;
            $this->isValidUniversity = true;
            return true;
        } else {
            $this->isValidUniversity = false;
            return false;
        }
    }

    /**
     * Returns the university.
     * @return string The university.
     */
    public function getUniversity(): string
    {
        return $this->university;
    }

    /**
     * Adds a movie to the collection.
     * @param movie $value The movie to be inserted.
     * @return bool True, if successful, otherwise false.
     */
    public function addMovie(movie $value): bool
    {
        try {
            $this->movies[] = $value;
            return true;
        } catch (Exception $e) {
            // Just for debug. Not in productive environment. There we shall not give to much feedback
            // because of security purposes.
            echo 'Exception abgefangen: ', $e->getMessage(), "\n";
            return false;
        }
    }

    /**
     * Gets a movie by its index.
     * @param int $value The index.
     * @return movie The movie or null
     */
    public function getMovie(int $value): movie
    {
        try {
            $index = $value - 1;

            $mov = $this->movies[$index];
            settype($mov, "object");
            return $mov;
        } catch (Exception $e) {
            // Just for debug. Not in productive environment. There we shall not give to much feedback
            // because of security purposes.
            echo 'Exception abgefangen: ', $e->getMessage(), "\n";
            return null;
        }
    }

    /**
     * Gets a movie by its storrage ID.
     * @param int $value The ID.
     * @return movie The movie or null.
     */
    public function getMovieByID(int $value): movie
    {
        try {
            foreach ($this->movies as $movie) {
                settype($movie, "object");

                if ($movie->getID() == $value) {
                    return $movie;
                }
            }

            return null;
        } catch (Exception $e) {
            // Just for debug. Not in productive environment. There we shall not give to much feedback
            // because of security purposes.
            echo 'Exception abgefangen: ', $e->getMessage(), "\n";
            return null;
        }
    }

    /**
     * Arranges the movies of the person.
     * @param int $dir The direction (1=up, 2=down).
     * @param int $field The field which should be arranged (1=title, 2=published, 3=rating).
     */
    public function orderMovieBy(int $dir, int $field)
    {
        $this->movies = array();
        $this->storage::orderMovieBy($dir, $field, $this);
    }

    /**
     * The number of available Movies.
     * @return int The number of Movies.
     */
    public function NumberOfMovies(): int
    {
        return count($this->movies);
    }

    /**
     * The textual description of an concrete Person.
     * @return string The description.
     */
    public function __toString()
    {
        return "{$this->lastname} , {$this->firstname} Movies: {$this->NumberOfMovies()}";
    }

    /**
     * Stores itselfs into a storage.
     * @return bool True, if successful, otherwise false.
     */
    public function saveToDatabase(): bool
    {
        return $this->storage::savePerson($this);
    }

    /**
     * Return whether a person is valid or not.
     * @return bool True, if valid, otherwise false.
     */
    public function isValidPerson(): bool
    {
        return (!empty($this->getFirstname()) && !empty($this->getLastname()) && !empty($this->getUniversity()));
    }
}