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

use classes\person;
use classes\htmlPage;

/**
 * Class viewSummaryPage Shows a page with personal data and available movies.
 * @package views Contains views
 */
class viewSummaryPage
{
    /**
     * The current person for whom the page should be shown
     * @var person|null
     */
    private $person = null;

    /**
     * viewSummaryPage constructor.
     * @param person $person The current person for whom the page should be shown
     */
    public function __construct(person $person)
    {
        $this->person = $person;
    }

    /**
     * Prints a summary page with personal data and available movies.
     */
    public function display()
    {
        if ($this->person != null) {
            $pageWriter = new htmlPage(PAGEHEADER, PAGEHEADER, PAGE_TITLE_SUMMARY);
            $content = $this->getSummaryPerson() . " " . $this->getSummaryMovie();

            $pageWriter->addContent($content);
            echo $pageWriter->getPageContent();
        }
    }

    /**
     * Returns an html snippet with personal data.
     * @return string The html snippet.
     */
    protected function getSummaryPerson(): string
    {
        $btnText = BTN_STRING_EDIT_PERSON;

        $firstname = LABEL_STRING_FIRSTNAME;
        $lastname = LABEL_STRING_LASTNAME;
        $university = LABEL_STRING_UNIVERSITY;

        $firstnameValue = $this->person->getFirstname();
        $lastnameValue = $this->person->getLastname();
        $universityValue = $this->person->getUniversity();

        $html = <<< summaryPersonHtml
    <table class="table">
    <tbody>
    <tr>
        <td>{$firstname}</td><td>{$firstnameValue}</td>
    </tr>
    <tr>
        <td>{$lastname}</td><td>{$lastnameValue}</td>
    </tr>
    <tr>
        <td>{$university}</td><td>{$universityValue}</td>
    </tr>
    </tbody>
    </table>
    
    <a href="{$_SERVER["PHP_SELF"]}?c=1&a=1">{$btnText}</a>
    </br></br> 
summaryPersonHtml;

        return $html;
    }

    /**
     * Returns an html snippet with movie data.
     * @return string The html snippet.
     */
    protected function getSummaryMovie(): string
    {
        $btnText = BTN_STRING_NEW_MOVIE;

        $strDeleteMovie = BTN_STRING_DELETE_MOVIE;
        $strEditMovie = BTN_STRING_EDIT_Movie;

        $strSortAsc = BTN_STRING_SORT_ASC;
        $strSortDesc = BTN_STRING_SORT_DESC;

        $html = <<< summaryMovieHtml
    <table class="table table-striped">
    <thead>
    <tr>
        <th>Nummer</th>
        <th>Titel <a href="{$_SERVER["PHP_SELF"]}?c=2&a=4&sa=1&i=1">{$strSortAsc}</a> <a href="{$_SERVER["PHP_SELF"]}?c=2&a=4&sa=2&i=1">{$strSortDesc}</a></th>
        <th>Erscheinungsjahr <a href="{$_SERVER["PHP_SELF"]}?c=2&a=4&sa=1&i=2">{$strSortAsc}</a> <a href="{$_SERVER["PHP_SELF"]}?c=2&a=4&sa=2&i=2">{$strSortDesc}</a></th>
        <th>Bewertung <a href="{$_SERVER["PHP_SELF"]}?c=2&a=4&sa=1&i=3">{$strSortAsc}</a> <a href="{$_SERVER["PHP_SELF"]}?c=2&a=4&sa=2&i=3">{$strSortDesc}</a></th>
    </tr>
    </thead>
    <tbody>
summaryMovieHtml;

        for ($i = 1; $i <= $this->person->NumberOfMovies(); $i++) {
            $mov = $this->person->getMovie($i);

            $html .= "" .
                "<tr><td>" . $i . "</td>" .
                "<td>" . $mov->getTitle() . "</td>" .
                "<td>" . $mov->getYear() . "</td>" .
                "<td>" . $mov->getRating() . "</td>" .
                "<td><a href=" . $_SERVER["PHP_SELF"] . "?c=2&a=1&id={$mov->getID()}>" . $strEditMovie . "</a></td>" .
                "<td><a href=" . $_SERVER["PHP_SELF"] . "?c=2&a=2&id={$mov->getID()}>" . $strDeleteMovie . "</a></td>";
        }

        $html .= <<< summaryMovieHtml
    </tbody>
    </table>
    </br>
    <a href="{$_SERVER["PHP_SELF"]}?&c=2&a=3">{$btnText}</a>
    </br></br>     

summaryMovieHtml;

        return $html;
    }
}