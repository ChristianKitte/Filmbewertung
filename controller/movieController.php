<?php
/**
 * Created by PhpStorm.
 * User: Christian Kitte
 * Date: 24.05.2017
 * Time: 15:27
 */

// The files have to be available. Therefore use "require" instead of "include".
require_once __DIR__ . "/../classes/person.php";
require_once __DIR__ . "/../classes/movie.php";
require_once __DIR__ . "/../views/viewMovieForm.php";
require_once __DIR__ . "/../views/viewSummaryPage.php";
require_once __DIR__ . "/../classes/IStorage.php";
require_once __DIR__ . "/../classes/databaseStorage.php";

use classes\movie;
use classes\person;
use classes\movieStringValidator;
use views\viewMovieForm;
use views\viewSummaryPage;
use classes\movieNumberValidator;

/**
 * Class movieController Controls the views for working  with movies.
 */
class movieController
{
    /**
     * @var person|null The person.
     */
    protected $person = null;
    /**
     * @var null The current view.
     */
    protected $curView = null;

    /**
     * movieController constructor.
     * @param person $person The context (as a person) on which the controller will work.
     */
    public function __construct(person $person)
    {
        $this->person = $person;
    }

    /**
     * Displays the needed page in context of the current state.
     */
    public function display()
    {
        if ($_SESSION["STATE"] == "ADD" && $_SESSION["SUBJECT"] == "MOVIE") {
            $movie = new movie(new movieStringValidator(), new movieNumberValidator());
            $this->getMovieDataFromPOST($movie);
        } else if ($_SESSION["STATE"] == "EDIT" && $_SESSION["SUBJECT"] == "MOVIE") {
            $movie = $this->person->getMovieByID($_SESSION["CURID"]);
            if ($movie != null) {
                $this->getMovieDataFromPOST($movie);
            } else {
                // there may be some reasons for no getting a movie.... For this shame we at least takes our user
                // into an valid state.

                $_SESSION["STATE"] = "SHOW";
                $_SESSION["SUBSTATE"] = "";
                $_SESSION["SUBJECT"] = "";

                $this->curView = new viewSummaryPage($this->person);
                $this->curView->display();
            }
        }

        if ($movie->isValidMovie()) {
            if ($_SESSION["STATE"] == "ADD" && $_SESSION["SUBJECT"] == "MOVIE") {
                $this->person->addMovie($movie);
            }

            $_SESSION["STATE"] = "SHOW";
            $_SESSION["SUBSTATE"] = "";
            $_SESSION["SUBJECT"] = "";
            $this->person->saveToDatabase();

            $this->curView = new viewSummaryPage($this->person);
            $this->curView->display();
        } else {
            $this->curView = new viewMovieForm($movie);
            $this->curView->display();
        }
    }

    /**
     * Gets data from the post-array and update the given movie object.
     * @param movie $movie The movie object
     */
    protected function getMovieDataFromPOST(movie $movie)
    {
        if (!empty($_POST[TITLE])) {
            $movie->setTitle(htmlspecialchars($_POST[TITLE]));
        }
        if (!empty($_POST[YEAR])) {
            $year = htmlspecialchars($_POST[YEAR]);

            if (is_numeric($year)) {
                $movie->setYear($year);
            }
        }
        if (!empty($_POST[RATING])) {
            $rating = htmlspecialchars($_POST[RATING]);

            if (is_numeric($rating)) {
                $movie->setRating($rating);
            }
        }
    }
}




