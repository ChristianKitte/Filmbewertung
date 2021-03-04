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

use classes\person;
use views\viewPersonForm;
use views\viewSummaryPage;

/**
 * Class personController Controls the views for working with persons.
 */
class personController
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
     * showController constructor.
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
        if ($_SESSION["STATE"] == "ADD" && $_SESSION["SUBJECT"] == "PERSON") {
            $this->getPersonDataFromPOST($this->person);
        } else if ($_SESSION["STATE"] == "EDIT" && $_SESSION["SUBJECT"] == "PERSON") {
            $this->getPersonDataFromPOST($this->person);
        } else if (empty($_SESSION["STATE"])) {
            $this->getPersonDataFromPOST($this->person);
        }

        if ($this->person->isValidPerson()) {
            $_SESSION["STATE"] = "SHOW";
            $_SESSION["SUBJECT"] = "";

            $this->curView = new viewSummaryPage($this->person);
            $this->curView->display();
        } else {
            $this->curView = new viewPersonForm($this->person);
            $this->curView->display();
        }
    }

    /**
     * Gets data from the post-array and update the given person object.
     * @param person $person The person object.
     */
    protected function getPersonDataFromPOST(person $person)
    {
        $save = true;
        if (!empty($_POST[FIRSTNAME])) {
            $save = $person->setFirstname(htmlspecialchars($_POST[FIRSTNAME]));
        }
        if (!empty($_POST[LASTNAME])) {
            $save = $person->setLastname(htmlspecialchars($_POST[LASTNAME]));
        }
        if (!empty($_POST[UNIVERSITY])) {
            $save = $person->setUniversity(htmlspecialchars($_POST[UNIVERSITY]));
        }

        if ($save) {
            $person->saveToDatabase();
        }
    }
}




