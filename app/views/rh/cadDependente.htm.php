<?php
if ($op == "cad"){
?>
<script>
$(function() {
        $("button,.botao, input:submit, input:button, button", "html").button();
        $("input:text").setMask();
       $("#formDependente").ajaxForm(function() {
                alert("Dependente cadastrado com Sucesso!!!");                
                return false;
            });
    });
</script>
<div id="conteudoCad" class="borda">
<?php
if (!empty($funcionario)){
echo $form->create("",array("id"=>"formDependente"));
echo $form->input("users_id",array("type"=>"hidden","value"=>$funcionario));
echo $form->input("nome",array("type"=>"text","class"=>"Form2Blocos","label"=>"Nome Completo"));
echo $form->input("nascimento",array("type"=>"text","class"=>"Form1Bloco","div"=>"ladoalado","alt"=>"date","label"=>"Data de Nascimento"));
echo $form->input("parentesco",array("type"=>"select","class"=>"Form1Bloco","label"=>"Grau de Parentesco","options"=>$parentescos));
echo $form->close("Inserir",array("class"=>"botao"));
}else{
echo "<center>";
echo "<div class='titulo'>Salve os dados para preencher essa etapa</div>";
echo "</center>";
}
?>
</div>
<?php
}else{
?>
<br>
<div id="gridCadastrados" class="borda">
<?php
    echo $xgrid->start($dependentesCad)
            ->caption("Dependentes")
            ->col('id')->hidden()
            ->col('users_id')->hidden()
            ->col('nome')->title('Nome')
            ->col("parentesco")->title("Grau")
            ->col("nascimento")->date("d/m/Y")
            ->col("parentesco")->conditions('parentesco', $parentescos)
            ->col('Deletar')->title('')->conditions('id', array(
                ">=1" => array("label" => "deletar.png", "href" => "javascript:load('gridDependente','/rh/delDependente/{id}','/rh/cadDependente/$funcionario')", "border" => "0")
            ))
            ->noData('Nenhum Dependente Cadastrado')
            ->alternate("grid_claro", "grid_escuro");
?>
</div>
<?php
}
?>