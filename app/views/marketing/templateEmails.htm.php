<script>
    $(function(){
        $("#formTemplateEmail").ajaxForm(function(data){
            alert(data);
        });
        $( "#accVars" ).accordion({
            heightStyle: "fill"
        });
        
    });
    
</script>


<?php
switch ($op) {
    case "cadastrar":
        echo $html->tag("h3", "Mensagens Padrões do Sistema", array("class" => "title"));
        echo $html->tag("script", "loadDiv('#auxMarketing','/marketing/templateEmails/listaVar');CKEDITOR.replace('FormMensagem',{toolbar:'Email',height:400});");
        echo $form->create("", array("class" => "formee", "id" => "formTemplateEmail"));
        echo $form->input("id_modulo", array("type" => "select", "options" => $optModulos, "label" => "Módulo", "div" => "grid-3-12", "value" => $dadosForm["id_modulo"]));
        echo $form->input("editavel", array("type" => "select", "options" => $bool, "div" => "grid-2-12", "value" => $dadosForm["editavel"]));
        echo $form->input("titulo", array("label" => "Título", "div" => "grid-7-12", "value" => $dadosForm["titulo"]));
        echo $form->input("assunto", array("div" => "grid-12-12", "value" => $dadosForm["assunto"]));
        echo $form->input("msgHistorico", array("label" => "Mensagem para Historico na Ficha do Destinatário", "div" => "grid-12-12", "value" => $dadosForm["msgHistorico"]));
        echo $form->input("mensagem", array("type" => "textarea", "div" => "grid-12-12", "label" => "Email", "value" => $dadosForm["mensagem"]));
        echo $form->close("Salvar", array("class" => "formee-button"));
        break;
    default:
    case "grid":
        echo $xgrid->start($dadosGrid)
                ->caption("Mensagens Cadastradas")
                ->alternate("grid_claro", "grid_escuro")
                ->hidden(array("mensagem", "templateEmail_id", "msgHistorico", "assunto", "created", "owner", "id_modulo"))
                ->col("modulo")->cellArray("nome")->title("Módulo")->position(0)
                ->col("titulo")->title("Título")->position(1)
                ->col("editavel")->conditions($bool)->position(2)
                ->col("modified")->title("Ult. Modificação")->date("d/m/Y H:i:s")->position(3)
                ->col("who")->title("Modificador")->position(4)
                ->col("editar")->title("")->cell("editar.png", "javascript:loadDiv('#contMarketing','/marketing/templateEmails/cadastrar/{templateEmail_id}');");
        break;
    case "listaVar":
        echo $html->openTag("div", array("id" => "accVars"));
        //Variáveis para menságens do Módulo de Importações
        echo $html->tag("h3", "Importações");
        echo $html->openTag("div");
        echo $html->tag("p","{nomeCliente}");
        echo $html->tag("p","{nomeContato}");
        echo $html->tag("p","{dataETA}");
        echo $html->tag("p","{siteAcompanhamento}");
        echo $html->tag("p","{numeroAcompanhamento}");
        echo $html->tag("p","{numeroProcesso}");
        echo $html->tag("p","{descricaoPedido}");
        echo $html->tag("p","{listaConteineres}");
        
        echo $html->closeTag("div");
        
        echo $html->tag("h3", "Comercial");
        echo $html->openTag("div");
        
        echo $html->closeTag("div");
        echo $html->closeTag("div");
        break;
}
?>
