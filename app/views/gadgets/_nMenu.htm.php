<?php
    echo $html->openTag("div",array("class"=>"menu"));
    echo $html->openTag("ul");
    echo $html->tag("li",$html->link("Home","/"));
    //echo $html->tag("li",$html->link("Recepção","/ferramentas/agendaContato"));
    echo $html->tag("li",$html->link("Comercial","/comercial/"));
    echo $html->tag("li",$html->link("Estoque","/estoque/"));
    echo $html->tag("li",$html->link("RH","/rh/"));
    echo $html->tag("li",$html->link("Importações","/importacoes/"));
    echo $html->tag("li",$html->link("Financeiro","/financeiro/"));
    echo $html->tag("li",$html->link("Marketing","/marketing/"));
    //echo $html->tag("li",$html->link("Site","/admsite/"));
    echo $html->tag("li",$html->link("Projetos","/projetos/"));
    echo $html->tag("li",$html->link("Solicitações","/solicitacoes/"));
    echo $html->tag("li",$html->link("Ferramentas","/ferramentas/"));
    echo $html->tag("li",$html->link("Admin","/admin/"));
    echo $html->closeTag("div");
?>