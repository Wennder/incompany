<script>
    $(function(){
        $("button,.botao, input:submit, input:button, button", "html").button();
        $("input:text").setMask();
    });
</script>
<?php
switch ($op) {
    default :
    case "grid":
        echo $xgrid->start($dadosGrid)
                ->alternate("grid_claro", "grid_escuro")
                ->caption("Configuração de ICMS");
        break;
    case "cadastrar":
        echo $form->create();
        echo $form->input("cfop",array("value"=>$dadosForm["cfop"]));
        echo $form->close("Salvar", array("class" => "botao"));
        break;
}
?>
