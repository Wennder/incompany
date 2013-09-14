<script>
$(function(){
    $("#contEticket").load("/eticket/Tickets/encaminhadas");
    $( "#radio" ).buttonset();
});
    
</script>

<?php
$this->pageTitle = "Solicitações :: Home";
//Título
echo $html->openTag("h3");
echo "Reembolsos";
echo $html->closeTag("h3");
//Botões
echo $html->link("Novo Pedido","javascript:AbreJanela('/solicitacoes/novo',480,450,'Novo Pedido de Reembolso');",array("class"=>"botao"));
echo $html->link("Buscar Pedido","javascript:AbreJanela('/solicitacoes/formBuscaReembolso',510,210,'Buscar Reembolso');",array("class"=>"botao"));
echo $html->link("A Aprovar [$numAprovar]","javascript:AbreJanela('/solicitacoes/reembolsoAprovar',650,600,'Reembolsos a Aprovar');",array("class"=>"botao"));
echo $html->link("Meus Reembolsos","javascript:AbreJanela('/solicitacoes/geradas', 650,600,'Meus Reembolsos');",array("class"=>"botao"));
echo "<br />";
echo "<br />";
 //Título
echo $html->openTag("div", array("style" => "width:41%; float:left;"));
echo $html->openTag("h3");
echo "E-tickets Departamentais";
echo $html->closeTag("h3");

echo $html->link("Novo","javascript:AbreJanela('/eticket/Tickets/novo',470,410,'Nova Solicitação Departamental');",array("class"=>"botao"));
//echo $html->link("Buscar", "javascript:AbreJanela('/eticket/Tickets/buscar',560,150,'Buscar Solicitação Departamental');",array("class"=>"botao"));

echo "<div id='radio' class='botao'>";
echo "<input type='radio' id='radio1' name='radio' checked='checked' onClick=\"loadDiv('#contEticket','/eticket/Tickets/encaminhadas');\" /><label for='radio1'>Para Mim</label>";
echo "<input type='radio' id='radio2' name='radio' onClick=\"loadDiv('#contEticket','/eticket/Tickets/grid');\" /><label for='radio2'>Abertos</label>";
echo "</div>";

echo "<br />";
echo "<br />";

echo $html->openTag("h3");
echo "Configuração do Módulo";
echo $html->closeTag("h3");

echo $html->link("Novo Status","javascript:AbreJanela('/eticket/status/novo',470,200,'Novo Status de Chamado Departamental');",array("class"=>"botao"));
echo $html->link("Status Disponíveis","javascript:AbreJanela('/eticket/status/grid',470,200,'Status dos Chamados Departamentais');",array("class"=>"botao"));
echo $html->closeTag("div");

echo $html->openTag("div", array("style" => "width:58%; float:right;","id"=>"contEticket"));

echo $html->closeTag("div");


?>