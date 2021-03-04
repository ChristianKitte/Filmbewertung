<?php
/**
 * Created by PhpStorm.
 * User: Christian Kitte
 * Date: 27.04.2017
 * Time: 21:14
 */

/*
 Defines all parameters for the app.
 */

/**
 * Establishes the person's id to 1. This will be object of change if there will be
 * more then one user.
 */
define("PERSONID", 1);

/**
 * Defines a page caption.
 */
define("PAGEHEADER", "Einsendeaufgabe 4");
/**
 * Defines the min ranking for a movie.
 */

define("MINNUMBER_POINT", 1);
/**
 * Defines the max ranking for a movie.
 */
define("MAXNUMBER_POINT", 10);
/**
 * Defines the min year for a movie. By the way the maximum date is determined by the
 * current year.
 */
define("MINYEAR", 1900);

/**
 * Defines the page title for the personal data page.
 */
define("PAGE_TITLE_PERSON", "Persönliche Daten");
/**
 * Defines the page title for the requested movies page.
 */
define("PAGE_TITLE_MOVIE", "Filmliste");
/**
 * Defines the page title for the summary page.
 */
define("PAGE_TITLE_SUMMARY", "Übersicht");
/**
 * Defines the page title for error pages.
 */
define("PAGE_TITLE_ERROR", "Fehler");

/**
 * Defines a variable name for first name. Also for used within POST and SESSION array.
 */
define("FIRSTNAME", "firstname");
/**
 * Defines a variable name for last name. Also for used within POST and SESSION array.
 */
define("LASTNAME", "lastname");
/**
 * Defines a variable name for university. Also for used within POST and SESSION array.
 */
define("UNIVERSITY", "university");
/**
 * Defines a variable name for title. Also for used within POST and SESSION array.
 */
define("TITLE", "title");
/**
 * Defines a variable name for year. Also for used within POST and SESSION array.
 */
define("YEAR", "year");
/**
 * Defines a variable name for rating. Also for used within POST and SESSION array.
 */
define("RATING", "rating");

/**
 * Defines a main caption for error pages.
 */
define("ERROR_MSG_CAPTION", "Fehler");
/**
 * Defines an error message for the case: missing or invalid first name.
 */
define("ERROR_MSG_FIRSTNAME_MISS", "Bitte den Vornamen eingeben. Hier dürfen nur Buchstaben, Bindestriche und Leerzeichen verwendet werden. Die Maximale Länge ist 20 Zeichen.");
/**
 * Defines an error message for the case: missing or invalid last name.
 */
define("ERROR_MSG_LASTNAME_MISS", "Bitte den Nachnamen eingeben. Hier dürfen nur Buchstaben, Bindestriche und Leerzeichen verwendet werden. Die Maximale Länge ist 30 Zeichen.");
/**
 * Defines an error message for the case: missing or invalid university.
 */
define("ERROR_MSG_UNIVERSITY_MISS", "Bitte die Hochschule eingeben. Hier dürfen nur Buchstaben, Bindestriche und Leerzeichen verwendet werden. Die Maximale Länge ist 25 Zeichen.");
/**
 * Defines an error message for the case: missing or invalid title.
 */
define("ERROR_MSG_TITLE_MISS", "Bitte den Filnamen eingeben. Hier dürfen nur Buchstaben, Bindestriche und Leerzeichen verwendet werden. Die Maximale Länge ist 50 Zeichen.");
/**
 * Defines an error message for the case: missing or invalid year.
 */
define("ERROR_MSG_YEAR_MISS", "Bitte eine vierstellige Jahreszahl ab 1900. Das Datum darf nicht in der Zukunft liegen.");
/**
 * Defines an error message for the case: missing or invalid rating.
 */
define("ERROR_MSG_RATING_MISS", "Bitte eine Zahl zwischen 1 und 10 eingeben.");
/**
 * Defines an error message for the case: invalid session.
 */
define("ERROR_MSG_SESSION_MISS", "Leider konnte Ihre Anfrage nicht bearbeitet werden. Bitte Versuchen Sie es erneut.");

/**
 * Defines a lable for a common sent button.
 */
define("BTN_STRING_SEND", "Absenden");
/**
 * Defines a lable for the action: New Movie.
 */
define("BTN_STRING_NEW_MOVIE", "Einen neuen Film hinzufügen");
/**
 * Defines a lable for the action: Delete Movie.
 */
define("BTN_STRING_DELETE_MOVIE", "Löschen");
/**
 * Defines a lable for the action: Edit Person.
 */
define("BTN_STRING_EDIT_PERSON", "Bearbeiten");
/**
 * Defines a lable for the action: Edit Movie.
 */
define("BTN_STRING_EDIT_Movie", "Bearbeiten");
/**
 * Defines a lable for the action: Sort ascending.
 */
define("BTN_STRING_SORT_ASC", "Auf");
/**
 * Defines a lable for the action: Sort descening.
 */
define("BTN_STRING_SORT_DESC", "Ab");

/**
 * Defines a label for first name.
 */
define("LABEL_STRING_FIRSTNAME", "Vorname");
/**
 * Defines a label for last name.
 */
define("LABEL_STRING_LASTNAME", "Nachname");
/**
 * Defines a label for university.
 */
define("LABEL_STRING_UNIVERSITY", "Hochschule");
/**
 * Defines a label for title.
 */
define("LABEL_STRING_TITLE", "Titel");
/**
 * Defines a label for year.
 */
define("LABEL_STRING_YEAR", "Erscheinungsjahr");
/**
 * Defines a label for rating.
 */
define("LABEL_STRING_RATING", "Bewertung");

/**
 * Defines a pattern for firstname.
 */
define("VALIDATION_PATERN_FIRSTNAME", "^[A-Za-z0-9äöüÄÖÜß\s_\-]{1,20}$");
/**
 * Defines a pattern for lastname.
 */
define("VALIDATION_PATERN_LASTNAME", "^[A-Za-z0-9äöüÄÖÜß\s_\-]{1,30}$");
/**
 * Defines a pattern for university.
 */
define("VALIDATION_PATERN_UNIVERSITY", "^[A-Za-z0-9äöüÄÖÜß\s_\-]{1,25}$");
/**
 * Defines a pattern for title.
 */
define("VALIDATION_PATERN_TITLE", "^[A-Za-z0-9äöüÄÖÜß\s_\-]{1,50}$");
