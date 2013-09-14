<script>
    $(function(){
        $("button,.botao, input:submit, input:button, button", "html").button();
        $("input:text").setMask();
        
        $("#cadGrupoEmpresa").ajaxForm(function(){
            alert("Cadastrado com sucesso");
            loadDiv("#contAdmin","/admin/grupoEmpresas/grid");
        });
    });
</script>
<?php
switch ($op) {
    default:
    case "grid":
        echo $xgrid->start($dadosGrid)
                ->caption("Grupos Cadastrados")
                ->col("nome")->title("Nome do Grupo")
                ->col("id")->title("Editar")->cell("editar.gif","javascript:AbreJanela('/admin/grupoEmpresas/cadastrar/{id}', 360, 150, 'Editar Grupo - {nome}', null, true);")
                ->col("deletar")->title("")->cell("deletar.png","javascript:delAjax('/admin/grupoEmpresas/deletar/{id}','contAdmin', '/admin/grupoEmpresas/grid');");
        break;
    case "cadastrar":
        echo $form->create("",array("id"=>"cadGrupoEmpresa"));
        echo $form->input("nome", array("type" => "text", "label" => "Nome Do Grupo:", "class" => "Form12Bloco", "value" => $dadosForm["nome"]));
        echo $form->close("Salvar", array("class" => "botao"));
        break;
}
?>