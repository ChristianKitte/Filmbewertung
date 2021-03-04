<?php
/**
 * Created by PhpStorm.
 * User: Christian Kitte
 * Date: 12.05.2017
 * Time: 15:27
 */

namespace views;

// The files have to be available. Therefore use "require" instead of "include".
require_once __DIR__ . "/../constants.php";
require_once __DIR__ . "/../classes/person.php";
require_once __DIR__ . "/../classes/htmlForm.php";
require_once __DIR__ . "/../classes/htmlPage.php";

use classes\htmlForm;
use classes\htmlPage;
use classes\person;

/**
 * Class viewPersonForm Shows an input page for personal data.
 * @package views Contains views
 */
class viewPersonForm
{
    /**
     * The current person for whom the page should be shown.
     * @var person|null
     */
    private $person = null;

    /**
     * viewPersonForm constructor.
     * @param person $person The current person for whom the page should be shown.
     */
    public function __construct(person $person)
    {
        $this->person = $person;
    }

    /**
     * Prints an input page for personal data.
     */
    public function display()
    {
        if ($this->person != null) {
            $formWriter = new htmlForm("nameForm", "POST", $_SERVER["PHP_SELF"]);
            $pageWriter = new htmlPage(PAGEHEADER, PAGEHEADER, PAGE_TITLE_PERSON);

            if (!$this->person->isValidFirstname()) {
                $formWriter->addErrorBlock(ERROR_MSG_FIRSTNAME_MISS, ERROR_MSG_FIRSTNAME_MISS);
            }
            //$formWriter->addFormInputFieldForText(FIRSTNAME, FIRSTNAME, LABEL_STRING_FIRSTNAME, $this->person->getFirstname(), FIRSTNAME, false, "");
            $formWriter->addFormInputFieldForText(FIRSTNAME, FIRSTNAME, LABEL_STRING_FIRSTNAME, $this->person->getFirstname(), FIRSTNAME, true, VALIDATION_PATERN_FIRSTNAME);

            if (!$this->person->isValidLastname()) {
                $formWriter->addErrorBlock(ERROR_MSG_LASTNAME_MISS, ERROR_MSG_LASTNAME_MISS);
            }
            //$formWriter->addFormInputFieldForText(LASTNAME, LASTNAME, LABEL_STRING_LASTNAME, $this->person->getLastname(), LASTNAME, false, "");
            $formWriter->addFormInputFieldForText(LASTNAME, LASTNAME, LABEL_STRING_LASTNAME, $this->person->getLastname(), LASTNAME, true, VALIDATION_PATERN_LASTNAME);

            if (!$this->person->isValidUniversity()) {
                $formWriter->addErrorBlock(ERROR_MSG_UNIVERSITY_MISS, ERROR_MSG_UNIVERSITY_MISS);
            }
            //$formWriter->addFormInputFieldForText(UNIVERSITY, UNIVERSITY, LABEL_STRING_UNIVERSITY, $this->person->getUniversity(), UNIVERSITY, false, "");
            $formWriter->addFormInputFieldForText(UNIVERSITY, UNIVERSITY, LABEL_STRING_UNIVERSITY, $this->person->getUniversity(), UNIVERSITY, true, VALIDATION_PATERN_UNIVERSITY);

            $pageWriter->addContent($formWriter->getForm());
            echo $pageWriter->getPageContent();
        }
    }
}