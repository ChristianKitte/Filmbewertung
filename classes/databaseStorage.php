<?php
/**
 * Created by PhpStorm.
 * User: Christian Kitte
 * Date: 29.04.2017
 * Time: 20:20
 */

namespace classes;

// The files have to be available. Therefore use "require" instead of "include".
require_once __DIR__ . "/person.php";
require_once __DIR__ . "/movie.php";

/**
 * Class databaseStorage A concrete storage for holding persons into an mySQL database.
 * @package classes
 */
class databaseStorage implements IStorage
{
    /**
     * An host of a database being able to save Persons.
     * @var string.
     */
    private static $servername = "Die IP Adresse 111.222.333.444";
    //private static $servername = "localhost";
    /**
     * A valid user.
     * @var string.
     */
    private static $user = "nutzer";
    //private static $user = "root";
    /**
     * A valid password.
     * @var string.
     */
    private static $pwd = "passwort";
    //private static $pwd = "";
    /**
     * A database being able to save Persons.
     * @var string.
     */
    private static $db = "datenbank";

    /**
     * Returns the person identified by its id. If there is no such person, a new one will be created.
     * @return null|person An instance of Person or null.
     * @param int $id The positive ID to be used as identifier or which identifies a person.
     */
    public static function getPerson(int $id): person
    {
        if ($id < 0) {
            return null;
        }

        try {
            $con = new \mysqli(databaseStorage::$servername, databaseStorage::$user, databaseStorage::$pwd);
            $con->select_db(databaseStorage::$db);

            if ($con->connect_error) {
                die("{$con->connect_error()} ");
            } else {
                $p = new person(new personStringValidator(), new databaseStorage());

                $sql = "select pers_id, pers_firstname, pers_lastname, pers_university from pers_root WHERE pers_id = {$id}";
                $results = $con->query($sql);

                // there will be no movies without a person...
                if ($results->num_rows > 0) {
                    foreach ($results as $result) {
                        $p->setID((int)$result["pers_id"]);
                        $p->setFirstname($result["pers_firstname"]);
                        $p->setLastname($result["pers_lastname"]);
                        $p->setUniversity($result["pers_university"]);
                    }
                }

                if ($p->getID() == -1) {
                    $p->setID($id);
                }

                $sql = "select * from pers_movie WHERE pers_id = {$p->getID()}";
                $results = $con->query($sql);

                // there will be no movies without a person...
                if ($results->num_rows > 0) {
                    foreach ($results as $result) {
                        $mov = new movie(new movieStringValidator(), new movieNumberValidator());

                        $mov->setID($result["movie_id"]);
                        $mov->setTitle($result["movie_name"]);
                        $mov->setYear($result["movie_year"]);
                        $mov->setRating($result["movie_rating"]);

                        $p->addMovie($mov);
                    }
                }

                $results->free();
                $con->close();

                return $p;
            }
        } catch (Exception $e) {
            // Just for debug. Not in productive environment. There we shall not give to much feedback
            // because of security purposes.
            echo 'Exception abgefangen: ', $e->getMessage(), "\n";
            return null;
        }
    }

    /**
     * Arranges the movie collection of a person.
     * @param int $dir The direction (1=up, 2=down)
     * @param int $field The field which should be arranged (1=title, 2=published, 3=rating)
     * @param person $person The person who owns the collection.
     * @return null
     */
    public static function orderMovieBy(int $dir, int $field, person $person)
    {
        if ($dir < 1 || $dir > 2) {
            return false;
        }
        if ($field < 1 || $field > 3) {
            return false;
        }
        if ($person == null) {
            return false;
        }

        try {
            $con = new \mysqli(databaseStorage::$servername, databaseStorage::$user, databaseStorage::$pwd);
            $con->select_db(databaseStorage::$db);

            $direction = "";
            if ($dir == 1) {
                $direction = "ASC";
            } else if ($dir == 2) {
                $direction = "DESC";
            }

            $sql = "";
            switch ($field) {
                case 1:
                    $sql = "select * from pers_movie WHERE pers_id = {$person->getID()} ORDER BY movie_name {$direction}";
                    break;
                case 2:
                    $sql = "select * from pers_movie WHERE pers_id = {$person->getID()} ORDER BY movie_year {$direction}";
                    break;
                case 3:
                    $sql = "select * from pers_movie WHERE pers_id = {$person->getID()} ORDER BY movie_rating {$direction}";
                    break;
            }

            $results = $con->query($sql);

            // there will be no movies without a person...
            if ($results->num_rows > 0) {
                foreach ($results as $result) {
                    $mov = new movie(new movieStringValidator(), new movieNumberValidator());

                    $mov->setID($result["movie_id"]);
                    $mov->setTitle($result["movie_name"]);
                    $mov->setYear($result["movie_year"]);
                    $mov->setRating($result["movie_rating"]);

                    $person->addMovie($mov);
                }
            }

            $results->free();
            $con->close();
        } catch (Exception $e) {
            // Just for debug. Not in productive environment. There we shall not give to much feedback
            // because of security purposes.
            echo 'Exception abgefangen: ', $e->getMessage(), "\n";
            return null;
        }
    }

    /**
     * Stores the given person into a storage.
     * @param person $person The Person.
     * @return bool True if successful, otherwise false.
     */
    public static function savePerson(person $person): bool
    {
        if ($person == null) {
            return false;
        }

        try {
            $con = new \mysqli(databaseStorage::$servername, databaseStorage::$user, databaseStorage::$pwd);
            $con->select_db(databaseStorage::$db);

            if ($con->connect_error) {
                die("{$con->connect_error()} ");
            } else {

                //just to avoid warnings
                $id = $person->getID();
                $fname = $person->getFirstname();
                $lname = $person->getLastname();
                $hs = $person->getUniversity();

                $sql = "select count(*) AS Anzahl from pers_root WHERE pers_id = $id";
                $result = $con->query($sql);

                //We'll use prepared statement to protect from SQL Injection
                if ((int)$result->fetch_assoc()["Anzahl"] == 0) {//not in database so insert it
                    $statementInsert = $con->prepare("insert into pers_root (pers_id, pers_firstname, pers_lastname, pers_university) VALUES (?,?,?,?)");
                    $statementInsert->bind_param('isss', $id, $fname, $lname, $hs);
                    $statementInsert->execute();
                } else {//in database so update it
                    $statementUpdate = $con->prepare("update pers_root set pers_firstname=?, pers_lastname=?, pers_university=? WHERE pers_id=?");
                    $statementUpdate->bind_param('sssi', $fname, $lname, $hs, $id);
                    $statementUpdate->execute();
                }

                $statementInsert = $con->prepare("insert into pers_movie (movie_name,movie_rating,movie_year,pers_id) VALUES (?,?,?,?)");
                $statementUpdate = $con->prepare("update pers_movie set movie_name=?, movie_rating=?, movie_year=?, pers_id=? WHERE movie_id = ?");
                $counter = $person->NumberOfMovies();
                for ($i = 1; $i <= $counter; $i++) {
                    $mov = $person->getMovie($i);
                    $movID = $mov->getID();

                    $sql = "select count(*) AS Anzahl from pers_movie WHERE movie_id = {$movID}";
                    $result = $con->query($sql);

                    $title = $mov->getTitle();
                    $year = $mov->getYear();
                    $rating = $mov->getRating();

                    if ((int)$result->fetch_assoc()["Anzahl"] == 0) {//not in database so insert it
                        $statementInsert->bind_param('siii', $title, $rating, $year, $id);
                        $statementInsert->execute();
                    } else {//in database so update it
                        $statementUpdate->bind_param('siiii', $title, $rating, $year, $id, $movID);
                        $statementUpdate->execute();
                    }
                }
            }

            $con->close();
            return true;
        } catch (Exception $e) {
            // Just for debug. Not in productive environment. There we shall not give to much feedback
            // because of security purposes.
            echo 'Exception abgefangen: ', $e->getMessage(), "\n";
            return false;
        }
    }

    /**
     * Deletes a Person by its ID.
     * @param int $id The person's ID.
     * @return bool True if successful, otherwise false.
     */
    public static function deletePerson(int $id): bool
    {
        try {
            $con = new  \mysqli(databaseStorage::$servername, databaseStorage::$user, databaseStorage::$pwd);
            $con->select_db(databaseStorage::$db);

            if ($con->connect_error) {
                die("{$con->connect_error()} ");
            } else {
                $con->query("delete FROM pers_movie WHERE pers_id={$id}");
                $con->query("delete FROM pers_root WHERE pers_id={$id}");
                $con->close();
                return true;
            }
        } catch (Exception $e) {
            // Just for debug. Not in productive environment. There we shall not give to much feedback
            // because of security purposes.
            echo 'Exception abgefangen: ', $e->getMessage(), "\n";
            return false;
        }
    }

    /**
     * Deletes an movie by its ID.
     * @param int $id The movies ID.
     * @return bool True, if successful, otherwise false.
     */
    public static function deleteMovie(int $id): bool
    {
        try {
            $con = new  \mysqli(databaseStorage::$servername, databaseStorage::$user, databaseStorage::$pwd);
            $con->select_db(databaseStorage::$db);

            if ($con->connect_error) {
                die("{$con->connect_error()}");
            } else {
                $con->query("delete FROM pers_movie WHERE movie_id={$id}");
                $con->close();
                return true;
            }
        } catch (\Exception $e) {
            // Just for debug. Not in productive environment. There we shall not give to much feedback
            // because of security purposes.
            echo 'Exception abgefangen: ', $e->getMessage(), "\n";
            return false;
        }
    }
}