<script type="text/javascript">
    $(function() {
        $("button,.botao, input:submit, input:button, button", "html").button();
        $("input:text").setMask();
        $("FormAgendaContato").ajaxForm(function() {
            alert("Contato cadastrado com Sucesso!!!");
            $("#cadAgendaContatos").dialog('close');
            return false;
        });
        
    });
</script>
<?php
switch ($op) {
    case "novo":
        echo $form->create("", array("id" => "FormAgendaContato"));
        echo $form->input("empresa", array("type" => "text", "label" => "Empresa Contato", "class" => "Form2Blocos", "value" => $dadosAgenda['empresa']));
        echo $form->input("contato", array("type" => "text", "label" => "Contato", "class" => "Form2Blocos", "value" => $dadosAgenda['contato']));
        echo $form->input("telefone", array("type" => "text", "label" => "Telefone", "class" => "Form1Bloco", "div" => "ladoalado", "value" => $dadosAgenda['telefone']));
        echo $form->input("fax", array("type" => "text", "label" => "Fax", "class" => "Form1Bloco", "value" => $dadosAgenda['fax']));
        echo $form->input("celular", array("type" => "text", "label" => "Celular", "class" => "Form1Bloco", "value" => $dadosAgenda['celular']));
        echo $form->input("email1", array("type" => "text", "label" => "E-mail 1", "class" => "Form1Bloco", "div" => "ladoalado", "value" => $dadosAgenda['email1']));
        echo $form->input("email2", array("type" => "text", "label" => "E-mail 2", "class" => "Form1Bloco", "value" => $dadosAgenda['email2']));
        echo $form->input("sysEmpresa_id", array("type" => "select", "options" => $comboEmpresa, "label" => "Empresa", "class" => "", "value" => $dadosAgenda['sysEmpresa_id']));
        echo $form->input("descricao", array("type" => "textarea", "label" => "Descrição", "class" => "Form2Blocos", "value" => $dadosAgenda['descricao']));
        echo $form->close("Salvar");
        break;
    case "grid":
        echo $xgrid->start($dadosGrid)
                ->caption("Contatos")
                ->noData('Nehum registro encontrado!')
                ->col("created")->date("d/m/Y H:i")->title("Cadastro")
                ->col("empresa")->title("Empresa Contato")
                ->col("contato")->title("Contato")
                ->col("email1")->title("E-mail")
                ->col("fax")->hidden()
                ->col("celular")->hidden()
                ->col("email2")->hidden()
                ->col("descricao")->hidden()
                ->col("id")->hidden()
                ->col("editar")->title("")->conditions("id", array(">=1" => array("label" => "editar.gif", "href" => "javascript:popIn('cadContato','/ferramentas/formContato/novo/{id}');", "border" => "0")))
                ->col('excluir')->title("")->conditions('id', array(
                    ">=1" => array("label" => "deletar.png", "href" => "javascript:delAjax('/ferramentas/formContato/deletar/{id}','gridContato','/ferramentas/formContato/grid/')", "border" => "0")
                ))
                ->alternate("grid_claro", "grid_escuro");

        break;
}
?>
