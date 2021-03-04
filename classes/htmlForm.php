<?php
/**
 * Created by PhpStorm.
 * User: Christian Kitte
 * Date: 10.05.2017
 * Time: 21:12
 */

namespace classes;

// The files have to be available. Therefore use "require" instead of "include".
require_once __DIR__ . "/../constants.php";

/**
 * Class htmlForm An abstract html formular. It creates an input page by adding elements through its methods.
 * @package classes
 */
class htmlForm
{
    /**
     * @var string Holds html code.
     */
    protected $formContent = "";
    /**
     * @var string Defines the global form-group class.
     */
    protected $formClass = "form-group";
    /**
     * @var string Defines the global form-control class.
     */
    protected $formControlClass = "form-control";

    /**
     * @var string Defines the form-name.
     */
    protected $formName = "";
    /**
     * @var string Defines the form-method.
     */
    protected $formMethod = "";
    /**
     * @var string Defines the target of the form (The page which will be called after click on the submit-button).
     */
    protected $formSubmitPage = "";

    /**
     * @var string Defines the target of the form (The page which will be called after click on the submit-button).
     */
    protected $formSubmitLabel = BTN_STRING_SEND;

    /**
     * htmlForm constructor.
     * @param string $name The name of the form.
     * @param string $method The method to be used.
     * @param string $submitPage The target page to receive the data.
     */
    public function __construct(string $name, string $method, string $submitPage)
    {
        $this->formName = $name;
        $this->formMethod = $method;
        $this->formSubmitPage = $submitPage;
    }

    /**
     * Returns a full qualified html form, ready to be insert into an html page.
     * @return string The html-form.
     */
    public function getForm(): string
    {
        $content = $this->formContent;

        $name = $this->formName;
        $method = $this->formMethod;
        $submitPage = $this->formSubmitPage;
        $btnStringSend = $this->formSubmitLabel;

        $var = <<<formContent

        <form method="{$method}" action="{$submitPage}" name="{$name}">
        {$content}
        <input type="submit" value="{$btnStringSend}">
        </form>

formContent;

        return $var;
    }/** @noinspection PhpInconsistentReturnPointsInspection */

    /**
     * Adds an input field for text into the current form.
     *
     * @param string $id The field ID.
     * @param string $name The field name.
     * @param string $label The field label.
     * @param string $default The default value.
     * @param string $placeholder The placeholder value.
     * @param string $required True, if required, otherwise false.
     * @param string $pattern A patetrn to validate the input.
     */
    public function addFormInputFieldForText(string $id, string $name, string $label, string $default, string $placeholder, bool $required, string $pattern)
    {
        $class = $this->formClass;
        $controlClass = $this->formControlClass;

        $requiredString = "";
        if ($required) {
            $requiredString = "required";
        }

        if (trim($pattern) == "") {
            $patternString = "";
        } else {
            $patternString = "pattern=\"{$pattern}\"";
        }

        $var = <<<formInputFieldForTextHtml
    <div class="{$class}">
        <label for="{$id}">{$label}</label>
        <input class="{$controlClass}" type="text" {$requiredString} {$patternString} id="{$id}" name="{$name}" value="{$default}" placeholder="{$placeholder}">
    </div>
formInputFieldForTextHtml;

        $this->formContent .= $var;
    }/** @noinspection PhpInconsistentReturnPointsInspection */

    /**
     * Adds an input field for text into the current form.
     *
     * @param string $id The field ID.
     * @param string $name The field name.
     * @param string $label The field label.
     * @param string $default The default value.
     * @param string $placeholder The placeholder value.
     * @param string $required True, if required, otherwise false.
     * @param string $pattern A patetrn to validate the input.
     */
    public function addFormInputFieldForNumbers(string $id, string $name, string $label, string $default, string $placeholder, bool $required, int $min, int $max)
    {
        $class = $this->formClass;
        $controlClass = $this->formControlClass;

        $requiredString = "";
        if ($required) {
            $requiredString = "required";
        }

        $var = <<<formInputFieldForTextHtml
    <div class="{$class}">
        <label for="{$id}">{$label}</label>
        <input class="{$controlClass}" type="number" {$requiredString} id="{$id}" name="{$name}" value="{$default}" min="{$min}" max="{$max}" placeholder="{$placeholder}">
    </div>
formInputFieldForTextHtml;

        $this->formContent .= $var;
    }/** @noinspection PhpInconsistentReturnPointsInspection */


    /**
     * Adds a combobox with numbers into the current form.
     *
     * @param string $id The field ID.
     * @param string $name The field name.
     * @param string $label The field label.
     * @param string $from The minimum number.
     * @param string $to The maximum number.
     * @param string $default The default (which will be selected).
     */
    public function addDropdownNumberInputField(string $id, string $name, string $label, int $from, int $to, int $default)
    {
        $class = $this->formClass;
        $controlClass = $this->formControlClass;

        $var = <<<formDropdownInputField
    <div class="{$class}">
    <label for="{$name}">{$label}</label>
    <select name="{$name}" id="{$id}"  class="{$controlClass}">
formDropdownInputField;

        for ($i = $from; $i <= $to; $i++) {
            if ($i == $default) {
                $var .= "<option value=\"$i\" selected>$i</option>";
            } else {
                $var .= "<option value=\"$i\">$i</option>";
            }
        }

        $var .= <<<formDropdownInputField
    </select>
    </div>
formDropdownInputField;

        $this->formContent .= $var;
    }/** @noinspection PhpInconsistentReturnPointsInspection */

    /**
     * Adds an error block into the current form.
     *
     * @param string $shortText The short error description.
     * @param string $longText The long error description.
     */
    function addErrorBlock(string $shortText, string $longText)
    {
        $var = <<< errorPageHtml
    <div class="alert alert-danger" role="alert">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <span class="sr-only">{$shortText}:</span>
        $longText
    </div>
errorPageHtml;

        $this->formContent .= $var;
    }
}