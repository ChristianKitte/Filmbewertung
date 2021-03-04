<?php
/**
 * Created by PhpStorm.
 * User: Christian Kitte
 * Date: 11.05.2017
 * Time: 14:32
 */

namespace classes;

/**
 * Class htmlPage An abstract html page. It creates an page by adding content through its methods. The
 * necessary surrounded code of the page will be provided by the class. Therefore one only have to add
 * real content (for instance a form).
 *
 * More than this we'll be able to extend the class with a complete new style without change the class's users.
 *
 * @package classes
 */
class htmlPage
{
    /**
     * @var string Holds html code.
     */
    private $pageContent = "";
    /**
     * @var string Defines the main class.
     */
    private $pageMainClass = "container";
    /**
     * @var string Defines the header class.
     */
    private $pageHeaderClass = "page-header";

    /**
     * @var string Defines the title.
     */
    private $title = "";
    /**
     * @var string Defines the header.
     */
    private $pageHeader = "";
    /**
     * @var string Defines the sub header.
     */
    private $subPageHeader = "";

    /**
     * htmlPage constructor.
     * @param string $title The title.
     * @param string $pageHeader The header.
     * @param string $subPageHeader The sub header.
     */
    public function __construct(string $title, string $pageHeader, string $subPageHeader)
    {
        $this->title = $title;
        $this->pageHeader = $pageHeader;
        $this->subPageHeader = $subPageHeader;
    }

    /**
     * Returns a full qualified html page, ready to be shown.
     * @return string The html code.
     */
    public function getPageContent(): string
    {
        //$pageHeader = PAGEHEADER;
        $content = $this->pageContent;

        $pageMainClass = $this->pageMainClass;
        $pageHeaderClass = $this->pageHeaderClass;

        $title = $this->title;
        $pageHeader = $this->pageHeader;
        $subPageHeader = $this->subPageHeader;


        $var = <<< pageHtml
    <html>
        <head>
            <meta charset="utf-8">
            <title>{$title}</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
            integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        </head>
        
        <body>
            <div class="{$pageMainClass}">
                <h1 class={$pageHeaderClass}>{$pageHeader}</h1>
                <h2>{$subPageHeader}</h2>

                {$content}

            </div>
        </body>
    </html>
pageHtml;

        return $var;
    }

    public function addContent(string $content)
    {
        $this->pageContent .= $content;
    }

    /**
     * Adds an error block into the current form.
     *
     * @param string $shortText The short error description.
     * @param string $longText The long error description.
     * @return null.
     */
    function addErrorPageContent(string $shortText, string $longText)
    {
        $html = <<< errorPageHtml
    <div class="alert alert-danger" role="alert">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <span class="sr-only">$shortText:</span>
        $longText
    </div>
errorPageHtml;

        $this->pageContent .= $html;
    }
}