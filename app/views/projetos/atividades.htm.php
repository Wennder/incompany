<script type="text/javascript">
    $(function(){
         $("button,.botao, input:submit, input:button, button", "html").button();
         $("input:text").setMask();
    });
</script>
<?php

switch ($op) {
    case "novo":

        echo $form->create("");

        echo $form->input("responsavel",array(
        "type"=>"select", "style"=>"height:100px;","multiple"=>"multiple", "class"=>"Form2Blocos", 
             "label"=>"Responsável","options"=>$dadosResponsavel,
             "value"=>$dadosForm['responsavel']["id"]
    ));

        echo $form->input("rh_setor_id", array(
            "type"=>"select","label"=>"Setor da atividade:" , 
            "class"=>"Form2Blocos","options"=>$dadosSetores,
            "value"=>$dadosForm['rh_setor_id']['id']
        ));

        echo $form->input("nome",array(
            "type"=>"text","label"=>"Nome da atividade",
            "class"=>"Form2Blocos","value"=>$dadosForm['nome']));

        echo $form->input("descricao", array(
            "type"=>"textarea","label"=>"Descrição da atividade",
            "class"=>"Form2Blocos","value"=>$dadosForm['descricao']
        ));

         echo $form->input("inicio", array(
       "alt"=>"date",  "class"=>"Form1Bloco", "div"=>"ladoalado",
             "label"=>"Previsão de início:",
        "value"=>$date->format("d-m-Y",$dadosForm['inicio'])
    ));

        echo $form->input("termino", array(
       "alt"=>"date",  "class"=>"Form1Bloco", "label"=>"Previsão de Término:",
        "value"=>$date->format("d-m-Y",$dadosForm['termino'])
    ));
       

        echo $form->close("Enviar",array("class"=>"botao"));


        break;

    case "grid":
        echo $xgrid->start($dadosGrid)
                ->caption("Meus projetos")
                ->alternate("grid claro", "grid escuro")
                ->hidden(array(
                    "id", "created", "modified", "comentarios", "projetos_milestones_id",
                    "descricao", "rh_setor_id", "projetos_projeto_id"
                ))
                ->col("projetos_projeto")->cellArray("nome")->title("Projeto")->position(4)
                ->col("projetos_milestones")->cellArray("nome")->title("Milestone")->position(6)
                ->col("ativo")->conditions("ativo",$bool)
                ->col("inicio")->title("Início previsto")->date("d-m-Y")
                ->col("termino")->title("Finalização prevista")->date("d-m-Y")
                ->col("Editar")->title("")->cell("editar.gif", "/projetos/atividades/novo/{projetos_projeto_id}/{projetos_milestones_id}/{id}")
                ->col("Excluir")->title("")->cell("deletar.png", "projetos/atividades/excluir/{id}");

        echo $html->link("Novo", "/projetos/atividades/novo", array(
            "class" => "botao"
        ));
        break;
    
    case "editar":
               
        echo $form->create("");
        
        pr($nomeMilestones);
        
        echo $form->input("responsavel",array(
        "type"=>"select", "class"=>"Form2Blocos", 
             "label"=>"Responsável","options"=>$dadosResponsavel,
             "value"=>$dadosForm['responsavel']["id"]
    ));

        echo $form->input("rh_setor_id", array(
            "type"=>"select","label"=>"Setor da atividade:" , 
            "class"=>"Form2Blocos","options"=>$dadosSetores,
            "value"=>$dadosForm['rh_setor_id']['id']
        ));
        
        echo $form->input("milestones",array(
            "type"=>"select","label"=>"Milestones",
            "class"=>"Form2Blocos",
            "options"=>$nomeMilestones,
            "value"=>$dadosForm['milestones']['id']
        ));

        echo $form->input("nome",array(
            "type"=>"text","label"=>"Nome da atividade",
            "class"=>"Form2Blocos","value"=>$dadosForm['nome']));

        echo $form->input("descricao", array(
            "type"=>"textarea","label"=>"Descrição da atividade",
            "class"=>"Form2Blocos","value"=>$dadosForm['descricao']
        ));

         echo $form->input("inicio", array(
       "alt"=>"date",  "class"=>"Form1Bloco", "div"=>"ladoalado",
             "label"=>"Previsão de início:",
        "value"=>$date->format("d-m-Y",$dadosForm['inicio'])
    ));

        echo $form->input("termino", array(
       "alt"=>"date",  "class"=>"Form1Bloco", "label"=>"Previsão de Término:",
        "value"=>$date->format("d-m-Y",$dadosForm['termino'])
    ));
       

        echo $form->close("Salvar",array("class"=>"ladoalado"));

        echo $html->link("Cancelar","/projetos/atividades", array(
            "class"=>"botao"
        ));
    break;
}
?>
