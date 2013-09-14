<?php
switch ($op) {
    case "novo":
        //monta o form
?>
        <script>
        $(function(){
        $("input:text").setMask();
        $("button,.botao, input:submit, input:button, button", "html").button();
        });</script>
<?php
        echo $form->create("", array("id" => "formAgendaContato"));
        echo $form->input("empresa", array("type" => "text", "label" => "Empresa Contato", "class" => "Form2Blocos", "value" => $dadosAgenda['empresa']));
        echo $form->input("contato", array("type" => "text", "label" => "Contato", "class" => "Form2Blocos", "value" => $dadosAgenda['contato']));
        echo $form->input("telefone", array("type" => "text", "alt" => "telefone", "label" => "Telefone", "class" => "Form1Bloco", "div" => "ladoalado", "value" => $dadosAgenda['telefone']));
        echo $form->input("fax", array("type" => "text", "alt" => "telefone", "label" => "Fax", "class" => "Form1Bloco", "value" => $dadosAgenda['fax']));
        echo $form->input("celular", array("type" => "text", "alt" => "telefone", "label" => "Celular", "class" => "Form1Bloco", "value" => $dadosAgenda['celular']));
        echo $form->input("email1", array("type" => "text", "label" => "E-mail 1", "class" => "Form1Bloco", "div" => "ladoalado", "value" => $dadosAgenda['email1']));
        echo $form->input("email2", array("type" => "text", "label" => "E-mail 2", "class" => "Form1Bloco", "value" => $dadosAgenda['email2']));
        echo $form->input("descricao", array("type" => "textarea", "label" => "Descrição", "class" => "Form2Blocos", "value" => $dadosAgenda['descricao']));
        echo $form->close("Salvar",array("class"=>"botao"));
        break;
    case "grid":
        //monta o grid
        // pr($dadosGrid);
        echo $xgrid->start($dadosGrid)
                ->caption("Contatos")
                ->noData('Nehum registro encontrado!')
                ->col("created")->hidden()
                ->col("empresa")->title("Empresa")
                ->col("contato")->title("Contato")
                ->col("email1")->hidden()
                ->col("fax")->title("Fax")
                ->col("sysEmpresas_id")->hidden()
                ->col("modified")->hidden()
                ->col("celular")->hidden()
                ->col("email2")->hidden()
                ->col("descricao")->hidden()
                ->col("id")->hidden()
                ->col("editar")->title("")->conditions("id", array(">=1" => array("label" => "editar.png", "href" => "javascript:loadDiv('#divFormContato','/ferramentas/agendaContato/novo/{id}');", "border" => "0")))
                ->col("ver")->title("")->conditions("id", array(">=1" => array("label" => "mais.png", "href" => "javascript:popIn('verAgendaContatos','/ferramentas/agendaContato/ver/{id}');", "border" => "0")))
                ->col('excluir')->title("")->conditions('id', array(
                    ">=1" => array("label" => "deletar.png", "href" => "javascript:delAjax('/ferramentas/agendaContato/deletar/{id}','gridAgendaContatos','/ferramentas/agendaContato/grid/')", "border" => "0")
                ))
                ->alternate("grid_claro", "grid_escuro");
        break;
    case "ver":
        // pr($dadosAgenda);
?>
        <fieldset>
            <legend><h1><?php echo $dadosAgenda['empresa'] ?></h1></legend>
            <table>
                <tr>
                    <td colspan="3"><b>Contato</b><br/><?php echo $dadosAgenda['empresa'] ?></td>
                </tr>
                <tr>
                    <td width="33%"><b>Telefone</b><br/><?php echo $dadosAgenda['telefone'] ?></td>
                    <td width="33%"><b>Celular</b><br/><?php echo $dadosAgenda['celular'] ?></td>
                    <td width="34%"><b>Fax</b><br/><?php echo $dadosAgenda['fax'] ?></td>
                </tr>
                <tr>
                    <td colspan="2"><b>E-mail</b><br/><?php echo $dadosAgenda['email1'] ?></td>
                    <td colspan="1"><b>E-mail²</b><br/><?php echo $dadosAgenda['email2'] ?></td>
                </tr>
            </table>
            <fieldset>
                <legend><b>Obs.:</b></legend>
        <?php echo $dadosAgenda['descricao'] ?>
    </fieldset>
</fieldset>
<?php
        break;
    default :
?>
        <script language="javascript" type="text/javascript">
            $(function(){
                $("#FormValue").keydown(function(){
                var field_post = $("#FormField").val();
                var value_post = $("#FormValue").val();
                $.post("/ferramentas/agendaContato/grid", {field: field_post, value:value_post}, function(data){
                    $("#gridAgendaContatos").html(data);
                });
            });
            $("#gridAgendaContatos").load("/ferramentas/agendaContato/grid");
            $("#formContato").ajaxForm();
            });

        </script>
<?php
	$this->pageTitle = "Recepção :: Telefonia";
	echo $html->openTag("div", array("style" => "width:49%; float:left;"));
	echo $html->openTag("h3");
	echo "Ações";
	echo $html->closeTag("h3");
	echo $html->openTag("fieldset");
	echo $html->tag("legend","Busca de Contatos");
        echo $form->create("/ferramentas/agendaContato/grid", array("id" => "formContato"));
        echo $form->input("field", array("type" => "select", "options" => array("Selecione...", "empresa" => "Empresa", "contato" => "Contato","descricao"=>"Descrição"), "label" => "Campo", "class" => "FormMeioBloco", "div" => "ladoalado"));
        echo $form->input("value", array("type" => "text", "label" => "Valor", "class" => "FormMetadeBloco"));
        echo $form->close();
        echo $html->closeTag("fieldset");
        
        
        echo $html->openTag("fieldset",array("style"=>"margin-top:20px;"));
	echo $html->tag("legend","Novo Contato");
	
	echo $html->openTag("div",array("id"=>"divFormContato"));	
	echo $form->create("/ferramentas/agendaContato/novo", array("id" => "formAgendaContato"));
        echo $form->input("empresa", array("type" => "text", "label" => "Empresa Contato", "class" => "Form2Blocos", "value" => $dadosAgenda['empresa']));
        echo $form->input("contato", array("type" => "text", "label" => "Contato", "class" => "Form2Blocos", "value" => $dadosAgenda['contato']));
        echo $form->input("telefone", array("type" => "text", "alt" => "telefone", "label" => "Telefone", "class" => "Form1Bloco", "div" => "ladoalado", "value" => $dadosAgenda['telefone']));
        echo $form->input("fax", array("type" => "text", "alt" => "telefone", "label" => "Fax", "class" => "Form1Bloco", "value" => $dadosAgenda['fax']));
        echo $form->input("celular", array("type" => "text", "alt" => "telefone", "label" => "Celular", "class" => "Form1Bloco", "value" => $dadosAgenda['celular']));
        echo $form->input("email1", array("type" => "text", "label" => "E-mail 1", "class" => "Form1Bloco", "div" => "ladoalado", "value" => $dadosAgenda['email1']));
        echo $form->input("email2", array("type" => "text", "label" => "E-mail 2", "class" => "Form1Bloco", "value" => $dadosAgenda['email2']));
        echo $form->input("descricao", array("type" => "textarea", "label" => "Descrição", "class" => "Form2Blocos", "value" => $dadosAgenda['descricao']));
        echo $form->close("Salvar",array("class"=>"botao"));
        echo $html->closeTag("div");
        
	echo $html->closeTag("fieldset");
	
	
	echo $html->closeTag("div");
	
	echo $html->openTag("div", array("style" => "width:49%; float:right;","id"=>"gridAgendaContatos"));
	echo $html->closeTag("div");
?>
        <script type="text/javascript">
            $(function(){
            $("#cadAgendaContatos").dialog({
            autoOpen: false,
            modal:true,
            height:400,
            width:500,
            buttons:{
            "Salvar":function(){
            $("#formAgendaContato").trigger("submit");
            }
            }
            });
            $("#gridAgendaContatos").load("/ferramentas/agendaContato/grid");

            $("#verAgendaContatos").dialog({
            autoOpen: false,
            modal:true,
            height:300,
            width:600
            });
            })
        </script>
        <br/>
        <div id="gridAgendaContatos"></div>
        <div id="verAgendaContatos" title="Detalhes do Contato"></div>
<?php
        break;
}
?>