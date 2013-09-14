<?php
echo $html->tag("div","&nbsp;",array("id"=>"auxRh","class"=>"grid_4"));

echo $html->openTag("div",array("id"=>"contRh","class"=>"grid_12"));
$this->pageTitle = "RH :: Home";

//Título
echo $html->openTag("h3");
echo "Gestão de RH";
echo $html->closeTag("h3");
//Botões
echo $html->link("Colaborador", "javascript:loadDiv('#contRh','/rh/colaborador/');",array("class"=>"botao"));
echo $html->link("Pré Cadastro", "/rh/preCadastroFuncionario/",array("class"=>"botao"));
echo $html->link("Cadastrar Colaborador", "/rh/cadFuncionario/",array("class"=>"botao"));
$pendentes = $geral->statusRh(array("conditions" => array("dt_admissao" => "0000-00-00")));
echo $html->link("Cadastros Pendentes [{$pendentes}]", "/rh/cadastrosPendentes/",array("class"=>"botao"));
echo $html->link("Buscar Colaborador","javascript:popIn('janelaModal','/rh/buscaFuncionario');",array("class"=>"botao"));
echo "<br />";
echo "<br />";
//Título
echo $html->openTag("h3");
echo "Configurações do Módulo";
echo $html->closeTag("h3");
//Botões
echo $html->link("Departamentos","/rh/cadDepartamento/",array("class"=>"botao"));
//Título
echo "<br />";
echo "<br />";
echo $html->openTag("h3");
echo "Relatórios";
echo $html->closeTag("h3");
//Botões
echo $html->link("Aniversariantes","javascript:popIn('janelaModal','/rh/relatorios/formAniversariantes');",array("class"=>"botao"));
echo $html->closeTag("div");
?>