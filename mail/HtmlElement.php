<?php

class HtmlElement 
{
    //This string holds what element it is, e.g "div"
    private $ElementType;
    //Associative array holding the element's attribute names and values
    private $AttributeList;
    //Array containing child HtmlElement instances
    private $Children;
    //Reference to the parent HtmlElement, if there is any
    public $Parent;

    //These are just here to make things more readable I guess
    private const ADD_PREFIX = 'add';
    private const SET_PREFIX = 'set';

    //This is used to translate e.g "paragraph" into "p"
    //After all, addParagraph() looks better than addP(), although both variants will work
    private const ELEMENT_TRANSLATIONS = [
        "paragraph", 
        "bold",
        "italic",
        "anchor",
        "quote",
        "strikethrough",
        "unarticulated"
    ];

    //Constructor takes element name and an assoc array with attributes
    public function __construct($elementName, $attributeList = []) 
    {
        $this->ElementType = $elementName;
        $this->AttributeList = $attributeList;
        $this->Children = [];
    }

    //This magic method is being used to handle "nonexisting" function calls
    //Using this, we can allow function calls like addDiv(), addScript(), or addAnyRandomElement()
    //Without actually having to define all of those functions
    public function __call($methodName, $arguments)
    {
        //Parse camelCase method name into an array (think of something like ["add", "Div"])
        $methodCasing = preg_split('#([A-Z][^A-Z]*)#', $methodName, null, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

        //Check if the parsing resulted into something useful
        if (count($methodCasing) > 1)
        {
            //Check if the method name prefix is "add", which means there is an attempt to add an element
            if ($methodCasing[0] == self::ADD_PREFIX)
            {
                //Remove "add" from the array, as we don't need it anymore (and we need to join() the array later)
                array_splice($methodCasing, 0, 1);
                //Check if the element to be added might qualify for translation
                if (count($methodCasing) == 1)
                {
                    //Make the element name lowercase
                    $methodCasing[0] = strtolower($methodCasing[0]);
                    //By default, we want the element to be translated
                    $translate = true;

                    //This is a somewhat complicated check to see if the arguments from the call contain a boolean
                    //This is because, although unlikely, you might want to have a <paragraph> element, which requires
                    //an addParagraph() call, which would normally translate to <p>. By adding "false", 
                    //We prevent the translation from happening
                    if (count($arguments) == 2 || count($arguments) == 1 && gettype($arguments[0]) == "boolean")
                    {
                        //Set the translation bool to whatever the boolean value of the given boolean argument
                        //It's also (somewhat) safe to assume that the boolean is the last parameter, which is what we're doing here
                        $translate = $arguments[count($arguments)-1];
                    }

                    //Check if we should translate, and if the element to be added is in fact an element that can be translated
                    if ($translate && in_array($methodCasing[0], self::ELEMENT_TRANSLATIONS)) 
                    {
                        //Set element name to its first letter using substr(), because p=paragraph, i=italic, etc etc
                        $methodCasing[0] = substr($methodCasing[0], 0, 1);
                    }
                }
                //This here, simply said, turns AnElement into an-element, SourceCode into source-code, etc
                //This is done so you can insert a "-" into your element name by simply using an uppercase letter
                //The replace is because underscores are also allowed, and without this replace, the following would happen:
                //a call to addSome_Element() would result in <some_-element>, which is not what we intended to do
                $elementName = str_replace("_-", "_", strtolower(join('-', $methodCasing)));
                //Empty array for arguments by default
                $elementArguments = [];
                //Check if there's more than 1 argument, and if that argument is an array, which would mean we're dealing with 
                //attributes
                if (count($arguments) > 0 && gettype($arguments[0]) == "array")
                {
                    //Now that we know it is indeed an array, we can simply assign that as our argument list
                    $elementArguments = $arguments[0];
                }

                //Add this element and its arguments to children and return it
                //We return it so that you can chain calls together e.g addDiv()->addParagraph(), resulting in <div><p></p></div>
                return $this->addChild($elementName, $elementArguments);
            }
            //If the prefix mentioned earlier isn't "add", we'll check if it's "set" instead, which means there is an attempt to
            //add/set an attribute
            else if ($methodCasing[0] == self::SET_PREFIX)
            {
                //Once again, remove the prefix from the array we parsed earlier
                array_splice($methodCasing, 0, 1);
                //Turn SomeAttribute into some-attribute, etc etc, same as before
                $attrName = str_replace("_-", "_", strtolower(join('-', $methodCasing)));
                
                //Check if there's any arguments
                //TODO: add support for value-less attributes like "defer" and "disabled"
                if (count($arguments) == 1)
                {
                    //Add attribute to the list of attributes and return the current HtmlElement
                    //Once again, this return is in order to allow the chaining of calls, e.g setClass("a-class")->setId("unique")
                    return $this->setAttribute($attrName, $arguments[0]);
                }
            }
    }
    }

    //This is here because the regular constructor isn't working the way I want it to work
    //TODO: Find a better way to do this, most likely using some sort of HtmlDocument class, still needs some thinking
    public static function Create($elementName, $attributeList = [])
    {
        return new HtmlElement($elementName, $attributeList);
    }

    //This function is being used internally to turn the class into a fancy HTML string
    //TODO: Add some kind of sanitizing stuff to try to prevent malformed HTML output as good as we can
    private function buildElement()
    {
        //Create the start of an opening tag
        $elementText = "<$this->ElementType";

        //Loop through all the attribute names and values
        foreach ($this->AttributeList as $attributeName => $attributeValue)
        {
            //Add them to the HTML string in the following format: ' name="value"'
            $elementText .= " $attributeName=\"$attributeValue\"";
        }
        //Close the opening tag
        $elementText .= ">";
        
        //Loop through all our children (which is weird, because I don't remember having kids at all..)
        foreach ($this->Children as $child)
        {
            //Simply add the child as if it were a string, because __toString() calls buildElement()
            $elementText .= $child;
        }

        //Add a closing tag
        $elementText .= "</$this->ElementType>";

        //And finally, return the string
        return $elementText;
    }

    //This is the base function that's being called whenever an "add{ElementName}" call is made, it's fairly simple
    //TODO: Make sure the attributes argument can be made non-optional
    private function addChild($elementName, $attributeList = [])
    {
        //Create a new class instance with the given element name and list of attributes
        $element = HtmlElement::Create($elementName, $attributeList);
        //Set the element's parent to the current HtmlElement instance, which may be useful
        $element->Parent = $this;
        //Add the new element to the current instance's children
        $this->Children[] = $element;
        //Return the element
        //Once again, this return is in order to allow the chaining of calls
        return $element;
    }

    //This is the base function that's being called whenever a "set{AttributeName} call is made, this is also fairly simple
    private function setAttribute($attrName, $attrValue)
    {
        //Add the attribute name and value to the current instance's assoc array containing all attributes
        $this->AttributeList[$attrName] = $attrValue;
        //Return the current instance
        //Once again, this return is in order to allow the chaining of calls
        return $this;
    }

    //This function is used to give an element some innerText
    public function text($string)
    {
        //Conveniently, we can simply add the text to the current instance's children and the buildElement() function will handle it
        $this->Children[] = $string;
        //Return the current instance
        //Once again, this return is in order to allow the chaining of calls
        return $this;
    }

    //This magic method decides what happens when our HtmlElement is treated as a string
    public function __toString()
    {
        //All we do is call the buildElement() function, which turns this instance into a nice HTML string
        return $this->buildElement();
    }

    //This is a helper function that checks wether a string starts with something
    private function startsWith($haystack, $needle) {
        return substr($haystack, 0, strlen($needle)) === $needle;
    }
}