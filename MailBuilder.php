<?php
include('HtmlElement.php');

class MailBuilder {
    public function __construct() {

    }
}

$body = HtmlElement::Create("html")->addBody();
$titles = $body->addDiv()->setClass("header")->addDiv()->setClass("header-content")->addDiv()->setClass("header-content-title");
$titles->addH1()->setClass("titel boven")->text("sprekende");
$titles->addH1()->setClass("titel onder")->text("kwaliteiten");
$body->addH1()->text("Jouw 'Sprekende Kwaliteiten' - Feedback");
$cardList = $body->addUl();

for ($i = 0; $i < 5; $i++)
{
    $cardList->addLi()->setClass("kaart")->addDiv()->setClass("kaartContainer")->addParagraph()->text("Testkaart $i");
}

$body->addDiv()->setClass("footer")->addP()->setClass("credits")->text("Sprekende Kwaliteiten is uitgevoerd met toestemming van Peter Gerrickens  en mogelijk gemaakt door Stichting Bartimeus Sonneheerdt en het KF Heinfonds");


//This whole thing is still in some sort of testing phase, I highly recommend you just ignore this!
echo $body;