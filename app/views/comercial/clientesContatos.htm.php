<script>
    $(function() {
        $("button,.botao, input:submit, input:button, button", "html").button();
        $("input:text").setMask();
        
        $("#FormContato").ajaxForm(function() {
            alert("Contato Cadastrado com Sucesso!!!");  
            $("#gridContatos").load("/comercial/clientesContatos/grid/<?php echo $idCliente ?>");
            return false;
        });
    });
</script>


<?php
$comboTipoContato = array("0"=>"Selecione...", "5"=>"Direção","1"=>"Administrativo", "2"=>"Comercial","3"=>"Compras / Suprimentos","6"=>"Comércio Exterior", "4"=>"Financeiro","7"=>"Técnico / Manutenção");
switch ($op) {
    case "cadastrar":
        echo $form->create("", array("id" => "FormContato", "class" => "formee"));
        echo $form->input("tipoContato", array("type" => "select", "options" => $comboTipoContato, "label" => "Tipo de Contato", "div" => "grid-12-12", "value" => $dados["tipoContato"]));
        echo $form->input("nome", array("type" => "text", "label" => "Nome", "div" => "grid-12-12", "value" => $dados["nome"]));
        echo $form->input("email", array("type" => "text", "label" => "E-mail", "div" => "grid-12-12", "value" => $dados["email"]));
        echo $form->input("tel1", array("type" => "text", "alt" => "", "label" => "Telefone", "alt" => "telefone", "div" => "grid-6-12", "value" => $dados["tel1"]));
        echo $form->input("tel2", array("type" => "text", "label" => "Telefone 2 ", "alt" => "telefone", "div" => "grid-6-12", "value" => $dados["tel2"]));
        echo $form->close("Salvar", array("class" => "botao grid-2-12"));
        break;
    case "grid":       
        echo $xgrid->start($gridContatos)
                ->caption("Contatos")
                ->noData('Nehum registro encontrado!')
                ->alternate("grid_claro", "grid_escuro")
                ->col("nome")->title("Nome")->slice("20")
                ->col("tipoContato")->title("Tipo Contato")->conditions("tipoContato", $comboTipoContato)->slice("10")
                ->col("email")->hidden()
                ->col("id_modulo")->hidden()
                ->col("tel1")->title("Telefone")
                ->col("tel2")->title("Telefone 2")
                ->col("modified")->hidden()
                ->col("id_cliente")->hidden()
                ->col("id")->hidden()
                ->col("created")->hidden()
                ->col('editar')->title("")->cell("editar.png", "javascript:AbreJanela('/comercial/clientesContatos/cadastrar/{id_cliente}/{id}', 500, 350, 'Cadastrar Contato', null, true);")
                ->col('deletar')->title("")->cell("deletar.png", "javascript:delAjax('/comercial/clientesContatos/deletar/{id_cliente}/{id}','gridContatos','/comercial/clientesContatos/grid/{id_cliente}')");
                
        break;

}
?>