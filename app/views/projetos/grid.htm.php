<?php
    echo $xgrid->start($dadosGrid)
            ->caption("Meus Projetos")
            ->alternate("grid_claro","grid_escuro")
            ->hidden(array("id","created","modified","milestones","atividades","comentarios","descricao"))
            ->col("cliente")->cellArray("nomeFantasia")
            ->col("valor")->currency()
            ->col("inicio")->date("d-m-Y")
            ->col("termino")->date("d-m-Y")
            ->col("responsavel")->cellArray("nome")
            ->col("ativo")->conditions("ativo",$bool)
            ->col("editar")->title("")->cell("editar.gif","/projetos/novo/{id}")
            ->col("excluir")->title("")->cell("deletar.png","/projetos/excluir/{id}");
    echo $html->link("*Novo","/projetos/novo",array(
        "class"=>"botao"
    ));
?>