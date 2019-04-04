<?php
include('HtmlElement.php');

class MailBuilder {
    public function __construct() {

    }
}

$body = HtmlElement::Create("html")->AddChild("body");
$titles = $body->AddChild("div", ["class" => "header"])->AddChild("div", ["class" => "header-content"])->AddChild("div", ["class" => "header-content-title"]);
$titles->AddChild("h1", ["class" => "titel boven"])->AddText("sprekende");
$titles->AddChild("h1", ["class" => "titel boven"])->AddText("kwaliteiten");
$body->AddChild("h1")->AddText("Jouw 'Sprekende Kwaliteiten' - Feedback");
$cardList = $body->AddChild("ul");

for ($i = 0; $i < 5; $i++)
{
    $cardList->AddChild("li", ["class" => "kaart"])->AddChild("div", ["class" => "kaartContainer"])->AddChild("p")->AddText("Testkaart $i");
}

$body->AddChild("div", ["class" => "footer"])->AddChild("p", ["class" => "credits"])->AddText("Sprekende Kwaliteiten is uitgevoerd met toestemming van Peter Gerrickens  en mogelijk gemaakt door Stichting Bartimeus Sonneheerdt en het KF Heinfonds");
echo $titles->Parent->Parent->Parent;