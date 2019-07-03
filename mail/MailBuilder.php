<?php
require('HtmlElement.php');

class MailBuilder {
    public $root;
    private $head;
    private $body;
    private $mailHeaders;
    private $subjectPrefs;
    private $subject;

    public function __construct()
    {
        $this->root = HtmlElement::Create("html")->setLang("nl=NL");
        $this->head = $this->root->addHead();
        $this->head->addStyle()->setType("text/css")->text(file_get_contents(__DIR__ . "/style.css"));
        $this->body = $this->root->addBody();

        $this->mailHeaders = [
            "Content-Transfer-Encoding" => "8bit",
            "Content-type" => "text/html; charset=UTF-8",
            "MIME-Version" => "1.0"
        ];

        $this->subjectPrefs = ["input-charset" => "UTF-8",
        "output-charset" => "UTF-8"];

        $titles = $this->body->addDiv()->setClass("header")->addDiv()->setClass("header-content")->addDiv()->setClass("header-content-title");
        $titles->addH1()->setClass("titel boven")->text("sprekende");
        $titles->addH1()->setClass("titel onder")->text("kwaliteiten");
    }

    public function setTitle($gameMode)
    {
        $this->body = $this->body->addCenter();
        $message = "Jouw 'Sprekende Kwaliteiten' - $gameMode";
        $this->body->addH1()->text($message);
        $this->subject = iconv_mime_encode("Subject", $message, $this->subjectPrefs);
    }

    public function setCustomMailHeader($name, $value)
    {
        $this->mailHeaders[$name] = $value;
    }

    public function setCustomSubjectPreferences($name, $value)
    {
        $this->subjectPrefs[$name] = $value;
    }

    public function insertCards($cardArray)
    {
        $cardList = $this->body->addUl();
        foreach ($cardArray as $key => $value)
        {
            if ($value != '')
            {
                $cardList->addLi()->setClass("kaart")->addDiv()->setClass("kaartContainer")->addParagraph()->text($value);
            }
        }
    }

    public function insertQuadrants($quadrants) 
    {
        $quadrantList = $this->body->addUl();
        foreach ($quadrants as $key => $value) 
        {
            $valueList = $quadrantList->addLi()->text($key)->addUl();
            $valueList->addLi()->text('Valkuil: ' . $value['valkuil']);
            $valueList->addLi()->text('Allergie: ' . $value['allergie']);
            $valueList->addLi()->text('Uitdaging: ' . $value['uitdaging']);
        }
    }

    private function getHeaderString()
    {
        $result = [];

        $this->mailHeaders["Date"] = date("r (T)");
        $this->mailHeaders["Subject"] = $this->subject;

        foreach ($this->mailHeaders as $key => $value)
        {
            //Don't add "Key: " prefix to the header if the key is Subject, apparently it already gets one by default
            $result[] = $key == "Subject" ? $value : "$key: $value";
        }

        return implode("\r\n", $result);
    }

    public function sendMail($recipient)
    {
        return mail($recipient, str_replace("Subject: ", "", $this->subject), (string)$this->root, $this->getHeaderString());
    }
}
