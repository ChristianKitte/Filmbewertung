<?php
/**
 * Created by PhpStorm.
 * User: Christian Kitte
 * Date: 17.04.2017
 * Time: 15:10
 */

/*
A page to collect some personal data and some movies. At the very first time visiting this page the user
has to give some personal data. After this a summary is shown. The user can add movies and also delete
previously added movies. It's also possible to sort the list of movies ascending and descending by its
title, year or rating. The user may be edit his personal data as well as his movies.

Validation take place by validator objects which will be passed to the person and movie objects. All
serialization tasks will be performed by an IStorage (in this case as a databaseStorage). This has to be
pass on as well.

The app is a kind of state driven one. At every time it is in a defined state and will be changed into another
by defined actions. These actions will be performed through get-parameters.

All possible get-parameters are defined as well. This give us the advantage, that only a few values will
be evaluated. All others therefore are not valid.

Within the index page, we divide main states. Within the showcontroller we analyze the get statements in deep.

For a better UX, some (unsecure) validation take place into the html page. This also works for editing. For
the case that a bad guy will sabotage this system, the app won't  accept the data (because of the inner
validation via PHP). But in this case, no information will be shown as well.

There a four states belonging to two subjects:
SESSION-ID      State
STATE           ==> NEW, EDIT, DELETE, SHOW
SUBJECT         ==> PERSON, MOVIE

Special SESSION values are:
CURID           ==> stores a movie id between two calls.
CURORDER        ==> sa  (1=up,      2=down)
CURORDERITEM    ==> i   (1=title,    2=year,     3=rating)

There a five parameters provided by GET:
GET-ID  stands for      possible values
c       = context       ==> 1=Person,   2=Movie
a       = action        ==> 1=Edit,     2=Delete,   3=Add,      4=Subaction
sa      = subaction     ==> 1=up,       2=down
i       = item          ==> 1=title,    2=year,     3=rating
id      = id

possible and therefore valid combination are as follow:
Person: EDIT
c=1,    a=1

Movie: EDIT, DELETE, ADD
c=2,    a=1     id
c=2,    a=2     id
c=2,    a=3

Movie Sort:
c=2,    a=4     sa=1    i=1  (up, title)
c=2,    a=4     sa=1    i=2  (up, year)
c=2,    a=4     sa=1    i=3  (up, rating)

c=2,    a=4     sa=2    i=1  (down, title)
c=2,    a=4     sa=2    i=2  (down, year)
c=2,    a=4     sa=2    i=3  (down, rating)
*/

// The files have to be available. Therefore use "require" instead of "include".
require_once __DIR__ . "/constants.php";
require_once __DIR__ . "/controller/personController.php";
require_once __DIR__ . "/controller/movieController.php";
require_once __DIR__ . "/controller/showController.php";
require_once __DIR__ . "/classes/htmlPage.php";
require_once __DIR__ . "/classes/person.php";
require_once __DIR__ . "/classes/databaseStorage.php";

use classes\databaseStorage;

// At the very first we'll start the session.
$sessionStarted = session_start();

// To Easily destroy a session or data
//session_destroy();
//databaseStorage::deletePerson(1);

if (!$sessionStarted) {//No valid session...
    $pageWriter = new classes\htmlPage(PAGEHEADER, PAGEHEADER, PAGE_TITLE_ERROR);
    $pageWriter->addErrorPageContent(ERROR_MSG_CAPTION, ERROR_MSG_SESSION_MISS);

    echo $pageWriter->getPageContent();
} else {// The main business logic.

    //There will only be one person...
    $person = databaseStorage::getPerson(PERSONID);
    settype($person, "object");

    if (empty($_SESSION["STATE"])) {//typically the first call
        $_SESSION["STATE"] = "";
        $_SESSION["SUBJECT"] = "";

        $controller = new personController($person);
        $controller->display();
    } else {
        switch ($_SESSION["STATE"]) {//we have four States
            case "NEW":
                if ($_SESSION["SUBJECT"] == "PERSON") {
                    $controller = new personController($person);
                    $controller->display();
                }
                break;
            case "EDIT":
                if ($_SESSION["SUBJECT"] == "PERSON") {
                    $controller = new personController($person);
                    $controller->display();
                }
                if ($_SESSION["SUBJECT"] == "MOVIE") {
                    $controller = new movieController($person);
                    $controller->display();
                }
                break;
            case "ADD":
                if ($_SESSION["SUBJECT"] == "MOVIE") {
                    $controller = new movieController($person);
                    $controller->display();
                }
                break;
            case "SHOW":
                $controller = new showController($person, new databaseStorage());
                $controller->display();
                break;
            default:
                break;
        }
    }


}

