<?php
if(in_array("1000",$pagesAvaible)||in_array("1020",$pagesAvaible)){
echo $html->openTag("h3");
echo "Status RH";
echo $html->closeTag("h3");
echo $html->openTag("div");
$mesAn = mktime(0, 0, 0, date("m") - 1, 01, date("Y"));
$mesAn = date("Y-m-d", $mesAn);
?>

<div class="mostradorStatusLateral">
    <ul>
        <li>Funcionários Cadastrados:<div><?php echo $assistec->statusRh(array("conditions" => array("grupoEmpresa_id" => $grupoEmpresa))); ?></div></li>
        <li>Funcionários Ativos:<div><?php echo $assistec->statusRh(array("conditions" => array("dt_desligamento =" => "0000-00-00", "dt_admissao <>" => "0000-00-00"))); ?></div></li>
        <li>Cadastros Pendentes:<div><a href="/rh/cadastrosPendentes/"><?php echo $assistec->statusRh(array("conditions" => array("dt_admissao" => "0000-00-00", "dt_admissao" => "0000-00-00"))); ?></a></div></li>
        <li>Cadastrados neste mês:<div><?php echo $assistec->statusRh(array("conditions" => array("created >" => date("Y-m-01")))); ?></div></li>
        <li>Cadastrados Mês Passado:<div><?php echo $assistec->statusRh(array("conditions" => array("created BETWEEN" => array($mesAn, date("Y-m-01"))))); ?></div></li>
        <li>Já Acessaram o SCR:<div><?php echo $assistec->statusRh(array("conditions" => array("password <>" => "NULL"))); ?></div></li>
    </ul>
</div>

<?php
echo $html->closeTag("div");
}
?>