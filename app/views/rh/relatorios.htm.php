<script>
    $("button,.botao, input:submit, input:button, button", "html").button();
    $("input:text").setMask();
</script>
<?php
switch ($op) {
    case "aniversariantesMes":
        echo $xgrid->start($dadosGrid)
            ->caption("Aniversariantes")
            ->noData("Nenhum aniversariante para o mês Escolhido")
            ->col("dt_nascimento")->title("Dia")->date("d")->position(0)
            ->hidden(array("rh_setor","empresa","grupo_empresa","financeiro_bancos","foto","gerente_funcionario"));
        break;
    case "formAniversariantes":
        echo $form->create("");
        echo $form->input("mes",array("type"=>"select","label"=>"Mês","class"=>"Form2Blocos","options"=>array("Selecione...","Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro")));
        echo $form->close("Gerar",array("class"=>"botao"));
        break;
}

?>