<?php
echo $form->create();
echo $html->openTag("ul");
echo $html->tag("li", $form->input("username", array("label" => "Usuário")));
echo $html->tag("li", $form->input("password", array("label" => "Senha")));
echo $html->closeTag("ul");
echo $form->close("Login", array("class" => "button black"));
?>
