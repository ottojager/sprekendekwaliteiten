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

        $this->mailHeaders = ["Content-Transfer-Encoding" => "8bit",
        "Content-type" => "text/html; charset=utf-8",
        "MIME-Version" => "1.0"];

        $this->subjectPrefs = ["input-charset" => "utf-8",
        "output-charset" => "utf-8",
        "line-length" => 76,
        "line-break-chars" => "\r\n"];

        $titles = $this->body->addDiv()->setClass("header")->addDiv()->setClass("header-content")->addDiv()->setClass("header-content-title");
        $titles->addH1()->setClass("titel boven")->text("sprekende");
        $titles->addH1()->setClass("titel onder")->text("kwaliteiten");
    }

    public function setTitle($gameMode)
    {
        $this->body = $this->body->addCenter();
        $message = "Jouw 'Sprekende Kwaliteiten' - $gameMode";
        $this->body->addH1()->text($message);
        $this->subject = $message;
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

    private function getHeaderString()
    {
        $result = [];

        $this->mailHeaders["Date"] = date("r (T)");
        $this->mailHeaders["Subject"] = str_replace("Subject: ", "", iconv_mime_encode("Subject", $this->subject, $this->subjectPrefs));

        foreach ($this->mailHeaders as $key => $value)
        {
            $result[] = "$key: $value";
        }

        return implode("\r\n", $result);
    }

    public function sendMail($recipient)
    {
        echo($this->getHeaderString());
        return;
        return mail($recipient, $this->subject, (string)$this->root, $this->getHeaderString());
    }
}
