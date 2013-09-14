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
        
        break;
    case "cadastrar":
        echo $form->create("",array("id"=>"formTaxaSiscomex"));
        echo $form->input("vDi",array("alt"=>"moeda","label"=>"Valor por DI","div"=>"Form50por FormLeft","value"=>$dadosForm["vDi"]));
        echo $form->input("vAdicao",array("alt"=>"moeda","label"=>"Valor por Adição","div"=>"Form50por FormRight","value"=>$dadosForm["vAdicao"]));
        echo $form->close("Salvar",array("class"=>"botao"));
        break;
}
?>
