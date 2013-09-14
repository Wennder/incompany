<?php

$this->pageTitle = "Projetos :: Home";
//Título
echo $html->openTag("div", array("style" => "width:70%; float:left;"));
echo $html->openTag("h3");
echo "Ações de Projetos";
echo $html->closeTag("h3");
//Botões
echo $html->link("Novo Projeto", "javascript:AbreJanela('/projetos/novo/', 480, 500, 'Novo Projeto');", array("class" => "botao"));
echo $html->link("Buscar Projeto", "/marketing/banners/novo", array("class" => "botao"));
echo "<br />";
echo "<br />";

//Titulo
echo $html->openTag("h3");
echo "Todos Projetos";
echo $html->closeTag("h3");
echo $html->closeTag("div");

echo $html->openTag("div", array("style" => "width:28%; float:right; margin-left:2%;"));

echo $xgrid->start($emAndamento)
        ->noData("Nenhum Registro Encontrado")
        ->caption("Projetos em Andamento")
        ->col("id")->title("ID")->cell("{id}","/projetos/gerencia/{id}")
        ->col("nome")->title("Nome")
        ->col("milestones")->hidden()
        ->col("comentarios")->hidden()
        ->col("cliente")->hidden()
        ->col("responsavel")->hidden();
echo "<br/>";


echo $xgrid->start($ptoControle)
        ->noData("Nenhum Registro Encontrado")
        ->caption("Pontos de Controle")
        ->col("id")->title("ID")
        ->col("previsao")->title("Previsão")->date("d/m/Y");
echo "<br/>";

echo $xgrid->start($qtdAtividades)
        ->noData("Nenhum Registro Encontrado")
        ->caption("Proximas Atividades")
        ->col("inicio")->title("Início")->date("d/m/Y")
        ->col("projeto")->position(1);
echo $html->closeTag("div");
?>