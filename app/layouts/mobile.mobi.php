<!DOCTYPE html>
<?php
echo $html->openTag("html");

//Tag HEAD
echo $html->openTag("head");
echo $html->tag("meta", "", array("name" => "viewport", "content" => "user-scalable=no, width=device-width"), true);
echo $html->tag("meta", "", array("name" => "apple-mobile-web-app-capable", "content" => "yes"), true);
echo $html->styleSheet("/mobile/css/mobile.css");
echo $html->closeTag("head");

//TAG BODY
echo $html->openTag("body");
echo $html->tag("div", $html->tag("h1", "e-Syntex"), array("id" => "header"));
echo $this->contentForLayout;
echo $html->tag("p", $html->tag("strong", "e-Syntex © Syntex International"));
echo $html->closeTag("body");

echo $html->closeTag("html");
?>

