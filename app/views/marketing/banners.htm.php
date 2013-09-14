<?php
$this->pageTitle = "Marketing :: Banners";
switch ($op) {
    case "grid":
        echo $html->link("*Novo Banner","/marketing/banners/novo",array("class"=>"botao"));

        echo "<br clear='all'/>";
        echo "<br clear='all'/>";
        echo $xgrid->start($dadosGrid)
                ->alternate("grid_claro", "grid_escuro")
                ->nodata("Nenhum Banner Encontrado")
                ->caption("Banners")
                ->hidden(array("conteudo", "created", "modified"))
                ->col("id")->title("Cód.")
                ->col("views")->title("Visualizações")
                ->col("tipo")->conditions("tipo", $tiposBanner)
                ->col("ativo")->conditions("ativo", $bool)->position(3)
                ->col("editar")->title("")->conditions("id", array(">=1" => array("label" => "editar.png", "href" => "/marketing/banners/novo/{id}", "border" => "0")))
                ->col('excluir')->title("")->conditions('id', array(
                    ">=1" => array("label" => "deletar.png", "href" => "javascript:deletar('/marketing/banners/deletar/{id}')", "border" => "0")
                ));
        break;

    case "novo":
       // echo $html->link("Imagem","javascript:AbreJanela('/marketing/banners/upload',500,200,'Upload Banner')",array("class"=>"botao"));
        echo $form->create();
        echo $form->input("conteudo", array("type" => "textarea", "class" => "editor", "value" => $dadosFormulario["conteudo"]));
        echo $form->input("nome",array("type"=>"text","label"=>"Nome","div"=>"ladoalado","value"=>$dadosFormulario['nome']));
        echo $form->input("tipo", array("type" => "select", "div" => "ladoalado", "label" => "Tipo de Banner", "options" => $tiposBanner));
        echo $form->input("ativo", array("type" => "select", "options" => $bool, "value" => $dadosFormulario["ativo"]));
        echo $form->close("Salvar", array("class"=>"botao"));
        break;
    case "upload":
        echo $form->create("",array("enctype" => "multipart/form-data"));
        echo $form->input("anexo", array("type"=>"file"));
        echo $form->close("Salvar",array("id"=>"btnSalva"));
        break;
}
?>
