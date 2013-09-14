<script>
    $(function(){
                
        $("button,.botao, input:submit, input:button, button", "html").button();
        $("input:text").setMask();
        $("#FormCidade").load("/integracao/options/sys_municipios/nome/<?php echo $dadosFormulario["cidade"] . "/uf/" . $dadosFormulario["estado"]; ?>");
                
        $("#FormEstado").change(function(){
            $("#FormCidade").load("/integracao/options/sys_municipios/nome/<?php echo "0" . "/uf/" ?>"+$("#FormEstado").val());
        });
        
        $("#buscaFornecedor").ajaxForm(function(){
            stateLoad("#contEstoque");
            $.post("/estoque/fornecedores/grid",$("#buscaFornecedor").serialize(), function(data){
                $("#contEstoque").html(data);
            });
        });
        
        $(document).ready(function() {
            
            $("#novaEmpresa").ajaxForm(function(data){
                alert("Cadastrado com Sucesso");
                $("#contEstoque").html(data);
            });
                
            
        });
    });
</script>

<?php
switch ($op) {
    default:
    case "grid":
        echo $xgrid->start($dadosGrid)
                ->caption("Fornecedores")
                ->alternate("grid_claro", "grid_escuro")
                ->noData("Nenhum registro encontrado")
                ->col("id")->hidden()
                ->col("nomeFantasia")->title("Nome")
                ->col("editar")->title("")->cell("editar.gif", "javascript:loadDiv('#contEstoque','/estoque/fornecedores/cadastrar/{id}');");
        break;

    case "cadastrar":
        echo $html->openTag("h3", array("class" => "title"));
        echo "Fornecedor {$dadosFormulario["razaoSocial"]}";
        echo $html->closeTag("h3");
        echo $form->create("", array("id" => "novaEmpresa", "class" => "formee"));
        echo $form->input("razaoSocial", array("type" => "text", "label" => "Razão Social:", "div" => "grid-12-12", "value" => $dadosFormulario["razaoSocial"]));
        echo $form->input("nomeFantasia", array("type" => "text", "label" => "Nome Fantasia:", "div" => "grid-12-12", "value" => $dadosFormulario["nomeFantasia"]));
        echo $form->input("cnpj", array("type" => "text", "alt" => "cnpj", "label" => "CNPJ:", "div" => "grid-4-12", "value" => $dadosFormulario["cnpj"]));
        echo $form->input("ie", array("type" => "text", "label" => "IE:", "div" => "grid-4-12", "value" => $dadosFormulario["ie"]));
        echo $form->input("im", array("type" => "text", "label" => "Inscrição Municipal:", "div" => "grid-4-12", "value" => $dadosFormulario["im"]));
        echo $form->input("endereco", array("type" => "text", "label" => "Endereço", "div" => "grid-10-12", "value" => $dadosFormulario["endereco"]));
        echo $form->input("nro", array("type" => "text", "label" => "Número", "div" => "grid-2-12", "value" => $dadosFormulario["nro"]));
        echo $form->input("complemento", array("type" => "text", "label" => "Complemento:", "div" => "grid-8-12", "value" => $dadosFormulario["complemento"]));
        echo $form->input("cep", array("type" => "text", "label" => "Cep:", "alt" => "cep", "div" => "grid-2-12", "value" => $dadosFormulario["cep"]));
        echo $form->input("bairro", array("type" => "text", "label" => "Bairro", "div" => "grid-2-12", "value" => $dadosFormulario["bairro"]));
        echo $form->input("estado", array("type" => "select", "label" => "Estado", "options" => $optionsEstados, "div" => "grid-2-12", "value" => $dadosFormulario["estado"]));
        echo $form->input("cidade", array("type" => "select", "label" => "Cidade", "div" => "grid-6-12", "options" => array("Selecione o Estado"), "value" => $dadosFormulario["cidade"]));
        echo $form->input("pais", array("type" => "text", "label" => "Pais", "div" => "grid-4-12", "value" => $dadosFormulario["pais"]));
        echo $form->input("tel", array("type" => "text", "alt" => "telefone", "label" => "Telefone", "div" => "grid-3-12", "value" => $dadosFormulario["tel"]));
        echo $form->input("cel", array("type" => "text", "alt" => "telefone", "label" => "Fax", "div" => "grid-3-12", "value" => $dadosFormulario["cel"]));
        echo $form->input("email", array("type" => "text", "label" => "E-mail", "div" => "grid-6-12", "value" => $dadosFormulario["email"]));
        echo $form->input("site", array("type" => "text", "label" => "Site:", "div" => "grid-12-12", "value" => $dadosFormulario["site"]));
        echo $form->close("Salvar", array("class" => "botao"));

        break;

    case "buscar":
        echo $html->tag("h3", "Buscar", array("class" => "title"));
        //Caixa de Busca de produtos
        echo $form->create("/estoque/fornecedores/grid", array("id" => "buscaFornecedor", "class" => "formee"));
        echo $form->input("nomeFantasia", array("type" => "text", "label" => "Nome", "div" => "grid-12-12"));
        echo $form->input("limit", array("type" => "select", "options" => array("10" => "10", "20" => "20", "30" => "30", "40" => "40", "50" => "50"), "div" => "grid-12-12", "label" => "Registros"));
        echo $form->close("Buscar", array("class" => "botao grid-12-12"));

        echo "<br clear='all' />";
        break;
}
?>