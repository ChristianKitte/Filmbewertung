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
require_once __DIR__ . "/../classes/movie.php";
require_once __DIR__ . "/../classes/htmlForm.php";
require_once __DIR__ . "/../classes/htmlPage.php";

use classes\movie;
use classes\htmlForm;
use classes\htmlPage;

/**
 * Class viewMovieForm Shows an input page for movies..
 * @package views Contains views
 */
class viewMovieForm
{
    /**
     * The current movie for which the page should be shown
     * @var movie|null
     */
    private $movie = null;

    /**
     * viewMovieForm constructor.
     * @param movie $movie The current movie for which the page should be shown.
     */
    public function __construct(movie $movie)
    {
        $this->movie = $movie;
    }

    /**
     * Prints an input page for movies.
     */
    public function display()
    {
        if ($this->movie != null) {
            $formWriter = new htmlForm("nameForm", "POST", $_SERVER["PHP_SELF"]);
            $pageWriter = new htmlPage(PAGEHEADER, PAGEHEADER, PAGE_TITLE_MOVIE);

            if (!$this->movie->isValidTitle()) {
                $formWriter->addErrorBlock(ERROR_MSG_TITLE_MISS, ERROR_MSG_TITLE_MISS);
            }
            //$formWriter->addFormInputFieldForText(TITLE, TITLE, LABEL_STRING_TITLE, $this->movie->getTitle(), TITLE, false, "");
            $formWriter->addFormInputFieldForText(TITLE, TITLE, LABEL_STRING_TITLE, $this->movie->getTitle(), TITLE, true, VALIDATION_PATERN_TITLE);

            if (!$this->movie->isValidYear()) {
                $formWriter->addErrorBlock(ERROR_MSG_YEAR_MISS, ERROR_MSG_YEAR_MISS);
            }
            $formWriter->addFormInputFieldForNumbers(YEAR, YEAR, LABEL_STRING_YEAR, $this->movie->getYear(), YEAR, false, MINYEAR, date("Y"));

            if (!$this->movie->isValidRating()) {
                $formWriter->addErrorBlock(ERROR_MSG_RATING_MISS, ERROR_MSG_RATING_MISS);
            }
            $formWriter->addDropdownNumberInputField(RATING, RATING, LABEL_STRING_RATING, MINNUMBER_POINT, MAXNUMBER_POINT, $this->movie->getRating());

            $pageWriter->addContent($formWriter->getForm());
            echo $pageWriter->getPageContent();
        }
    }
}