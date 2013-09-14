
<?php
$this->pageTitle = "Administração do Site :: Páginas";
switch ($op) {
            
            default:
            case "grid":
                echo $xgrid->start($dadosGrid)
                    ->caption("Paginas Existentes")
                    ->alternate("grid_claro","grid_escuro")
                    ->col("ativo")->conditions(array("0"=>"Não","1"=>"Sim"))
                    ->col("titulo_id")->title("Titulo ID")
                    ->col("modified")->title("Ult. Alteração")->date("d/m/Y H:i:s")
                    ->col("alterar")->title("")->cell("editar.gif","/admsite/Pages/add/{id}")
                    ->hidden(array("titulo","tags","conteudo","categoria_id", "created","fixo"));
                break;
            
            case "add":
                echo $form->create();
                echo $form->input("titulo", array("class"=>"Form2Blocos", "value"=>$dadosForm["titulo"]));
                echo $form->input("fixo", array("label"=>"Página Fixa", "div"=>"ladoalado", "class"=>"Form1Bloco","type"=>"select","options"=>array("Não","Sim"),"value"=>$dadosForm["fixo"]));
                echo $form->input("ativo", array("label"=>"Ativo","class"=>"Form1Bloco","type"=>"select","options"=>array("Não","Sim"),"value"=>$dadosForm["ativo"]));
                echo $form->input("tags", array("label"=>"Tags (Separados por virgula)","class"=>"Form2Blocos", "value"=>$dadosForm["tags"]));
                echo "<br />";
                echo $form->input("conteudo",array("type"=>"textarea","class"=>"editor","label"=>false,"value"=>$dadosForm["conteudo"]));
                echo $form->close("Publicar",array("class"=>"botao"));
                break;

            case "delete":
                break;
        }
?>
<script>
    $(function(){
        CKEDITOR.instances['FormConteudo'].destroy();

        CKEDITOR.replace("FormConteudo", {
           toolbar:'Full' 
        });
    });
</script>