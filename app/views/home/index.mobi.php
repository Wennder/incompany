<?php
    echo $html->openTag("ul");
    echo $html->tag("li",$html->link("Home","/"),array("class"=>"arrow"));
    echo $html->tag("li",$html->link("Comercial","/comercial/"),array("class"=>"arrow"));
    echo $html->tag("li",$html->link("Estoque","/estoque/"),array("class"=>"arrow"));
    echo $html->tag("li",$html->link("RH","/rh/"),array("class"=>"arrow"));
    echo $html->tag("li",$html->link("Importações","/importacoes/"),array("class"=>"arrow"));
    echo $html->tag("li",$html->link("Financeiro","/financeiro/"),array("class"=>"arrow"));
    echo $html->tag("li",$html->link("Marketing","/marketing/"),array("class"=>"arrow"));
    //echo $html->tag("li",$html->link("Site","/admsite/"));
    echo $html->tag("li",$html->link("Projetos","/projetos/"),array("class"=>"arrow"));
    echo $html->tag("li",$html->link("Solicitações","/solicitacoes/"),array("class"=>"arrow"));
    echo $html->tag("li",$html->link("Ferramentas","/ferramentas/"),array("class"=>"arrow"));
    echo $html->closeTag("ul");
?>