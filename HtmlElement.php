<?php

class HtmlElement 
{
    private $ElementType;
    private $AttributeList;
    private $Children;
    public $Parent;

    public function __construct($_element, $_attributes = []) 
    {
        $this->ElementType = $_element;
        $this->AttributeList = $_attributes;
        $this->Children = [];
    }

    // This is here because the regular constructor isn't working the way I want it to work
    public static function Create($_element, $_attributes = [])
    {
        return new HtmlElement($_element, $_attributes);
    }

    // This may or may not need some escaping to prevent malformed HTML, but for now, who really cares?
    private function BuildElement()
    {
        $elementText = "<$this->ElementType";

        foreach ($this->AttributeList as $attributeName => $attributeValue)
        {
            $elementText .= " $attributeName=\"$attributeValue\"";
        }
        $elementText .= ">";
        
        foreach ($this->Children as $child)
        {
            $elementText .= $child;
        }

        $elementText .= "</$this->ElementType>";

        return $elementText;
    }

    // This, I kinda like
    public function AddChild($_element, $_attributes = [])
    {
        $element = HtmlElement::Create($_element, $_attributes);
        $element->Parent = $this;
        $this->Children[] = $element;
        return $element;
    }

    public function AddText($string)
    {
        $this->Children[] = $string;
        return $this;
    }

    public function __toString()
    {
        return $this->BuildElement();
    }
}