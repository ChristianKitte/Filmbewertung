<?php
/**
 * Created by PhpStorm.
 * User: Christian Kitte
 * Date: 15.05.2017
 * Time: 14:23
 */

namespace classes;

/**
 * Interface IStorage Defines an interface for a storage. A storage is a construct to store our data (for instance a database).
 * @package classes
 */
interface IStorage
{
    /**
     * Returns the person identified by its id. If there is no such person, a new one will be created.
     * @return null|person An instance of Person or null.
     * @param int $id The ID to be used as identifier.
     */
    public static function getPerson(int $id): person;

    /**
     * Arranges the movie collection of a person.
     * @param int $dir The direction (1=up, 2=down)
     * @param int $field The field which should be arranged (1=title, 2=published, 3=rating)
     * @param person $person The person who owns the collection.
     * @return null
     */
    public static function orderMovieBy(int $dir, int $field, person $person);

    /**
     * Stores the given person into a storage.
     * @param person $person The Person.
     * @return bool True if successful, otherwise false.
     */
    public static function savePerson(person $person): bool;

    /**
     * Deletes a Person by its ID.
     * @param int $id The person's ID.
     * @return bool True if successful, otherwise false.
     */
    public static function deletePerson(int $id): bool;

    /**
     * Deletes an movie by its ID.
     * @param int $id The movies ID.
     * @return bool True, if successful, otherwise false.
     */
    public static function deleteMovie(int $id): bool;
}