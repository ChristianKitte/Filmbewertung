<?php
/**
 * Created by PhpStorm.
 * User: Christian Kitte
 * Date: 24.05.2017
 * Time: 15:27
 */

// The files have to be available. Therefore use "require" instead of "include".
require_once __DIR__ . "/../classes/person.php";
require_once __DIR__ . "/../views/viewPersonForm.php";
require_once __DIR__ . "/../views/viewSummaryPage.php";
require_once __DIR__ . "/../classes/IStorage.php";
require_once __DIR__ . "/../classes/databaseStorage.php";
require_once __DIR__ . "/../classes/movieStringValidator.php";
require_once __DIR__ . "/../classes/movieNumberValidator.php";

use classes\IStorage;
use classes\movie;
use classes\movieNumberValidator;
use classes\movieStringValidator;
use classes\person;
use views\viewMovieForm;
use views\viewPersonForm;
use views\viewSummaryPage;


/**
 * Class showController Controlls the views for summaries.
 */
class showController
{
    /**
     * @var person|null The person.
     */
    protected $person = null;
    /**
     * @var null The storage.
     */
    protected $storage = null;
    /**
     * @var null The current view.
     */
    protected $curView = null;

    /**
     * showController constructor.
     * @param person $person The context (as a person) on which the controller will work.
     * @param IStorage $storage An IStorage to access the object.
     */
    public function __construct(person $person, IStorage $storage)
    {
        $this->person = $person;
        $this->storage = $storage;
    }

    /**
     * Displays the needed page in context of the current state and the actual get-values
     */
    public function display()
    {
        if ($this->person->isValidPerson()) {
            if (!isset($_GET["c"])) {//just show
                if (isset($_SESSION["CURORDER"]) && isset($_SESSION["CURORDERITEM"])) {
                    $this->person->orderMovieBy($_SESSION["CURORDER"], $_SESSION["CURORDERITEM"]);
                }

                $this->curView = new viewSummaryPage($this->person);
                $this->curView->display();
            } else {//there is an request...
                if (htmlspecialchars($_GET["c"]) == "1") {//person
                    if (htmlspecialchars($_GET["a"]) == "1") {//edit
                        $_SESSION["STATE"] = "EDIT";
                        $_SESSION["SUBJECT"] = "PERSON";
                        $_SESSION["CURID"] = $this->person->getID();

                        $this->curView = new viewPersonForm($this->person);
                        $this->curView->display();
                    }
                } else if (htmlspecialchars($_GET["c"]) == "2") {//movie
                    if (htmlspecialchars($_GET["a"]) == "1") {//edit
                        $_SESSION["STATE"] = "EDIT";
                        $_SESSION["SUBJECT"] = "MOVIE";
                        $_SESSION["CURID"] = $_GET["id"];

                        $this->curView = new viewMovieForm($this->person->getMovieByID($_GET["id"]));
                        $this->curView->display();
                    } else if (htmlspecialchars($_GET["a"]) == "2") {//delete
                        //there's no need to set a global state.

                        $var = htmlspecialchars($_GET["id"]);
                        if (is_numeric($var)) {
                            $this->storage->deleteMovie($var);
                        }

                        //we need to update our person object
                        $this->person = $this->storage::getPerson($this->person->getID());

                        $this->curView = new viewSummaryPage($this->person);
                        $this->curView->display();
                    } else if (htmlspecialchars($_GET["a"]) == "3") {//add
                        $_SESSION["STATE"] = "ADD";
                        $_SESSION["SUBJECT"] = "MOVIE";

                        $this->curView = new viewMovieForm(new movie(new movieStringValidator(), new movieNumberValidator()));
                        $this->curView->display();
                    } else if (htmlspecialchars($_GET["a"]) == "4") {//subaction
                        //there's no need to set a global state.

                        $_SESSION["CURORDER"] = htmlspecialchars($_GET["sa"]);
                        $_SESSION["CURORDERITEM"] = htmlspecialchars($_GET["i"]);

                        $this->person->orderMovieBy(htmlspecialchars($_GET["sa"]), htmlspecialchars($_GET["i"]));

                        $this->curView = new viewSummaryPage($this->person);
                        $this->curView->display();
                    }
                }
            }
        } else {//fall back if there is no valid user stored in database...
            $_SESSION["STATE"] = "NEW";
            $_SESSION["SUBJECT"] = "PERSON";

            $this->curView = new viewPersonForm($this->person);
            $this->curView->display();
        }
    }
}




