<script type="text/javascript">
    $(document).ready(function() {
        $("button,.botao, inputsubmit, inputbutton, button", "html").button();
        $("inputtext").setMask();

        $("#novaEmpresa").ajaxForm(function(){
            alert("Cadastrado com Sucesso!");
            loadDiv("#contAdmin","/admin/empresas");
        });
        
        $("#FormCidade").load("/integracao/options/sys_municipios/nome/<?php echo $dados["cidade"] . "/uf/" . $dados["estado"]; ?>");
        
        $("#FormEstado").change(function(){
        $("#FormCidade").load("/integracao/options/sys_municipios/nome/<?php echo "0" ."/uf/"?>"+$("#FormEstado").val());
        });
    });
</script>
<h3>Cadastro de Nova Empresa</h3>
<?php
echo $form->create("", array("id" => "novaEmpresa", "class" => "formee"));
echo $form->input("razaoSocial", array("type" => "text", "label" => "Razão Social", "div" => "grid-12-12", "value" => $dados["razaoSocial"]));
echo $form->input("nomeFantasia", array("type" => "text", "label" => "Nome Fantasia", "div" => "grid-12-12", "value" => $dados["nomeFantasia"]));
echo $form->input("ativo", array("type" => "select", "label" => "Status", "options" => array("1" => "Ativa", "0" => "Desativada"), "div" => "grid-4-12", "value" => $dados["ativo"]));
echo $form->input("grupoEmpresa_id", array("type" => "select", "options" => $grupo, "label" => "Selecione o Grupo", "div" => "grid-4-12", "value" => $dados["grupoEmpresa_id"]));
echo $form->input("crt", array("type" => "select", "label" => "CRT", "options" => array("1" => "Simples Nacional", "2" => "Simples Nacional - Excesso", "3" => "Regime Normal"), "div" => "grid-4-12", "value" => $dados["crt"]));
echo $form->input("cnpj", array("type" => "text", "alt" => "cnpj", "label" => "CNPJ", "div" => "grid-3-12", "value" => $dados["cnpj"]));
echo $form->input("ie", array("type" => "text", "label" => "IE", "div" => "grid-3-12", "value" => $dados["ie"]));
echo $form->input("im", array("type" => "text", "label" => "Inscrição Municipal", "div" => "grid-3-12", "value" => $dados["im"]));
echo $form->input("cnae", array("type" => "text", "label" => "CNAE", "div" => "grid-3-12", "value" => $dados["cnae"]));
echo $form->input("endereco", array("type" => "text", "label" => "Rua/Av.", "div" => "grid-10-12", "value" => $dados["endereco"]));
echo $form->input("nro", array("type" => "text", "label" => "Número", "div" => "grid-2-12", "value" => $dados["nro"]));
echo $form->input("complemento", array("type" => "text", "label" => "Complemento", "div" => "grid-8-12", "value" => $dados["complemento"]));
echo $form->input("cep", array("type" => "text", "label" => "Cep", "alt" => "cep", "div" => "grid-2-12", "value" => $dados["cep"]));
echo $form->input("bairro", array("type" => "text", "label" => "Bairro", "div" => "grid-2-12", "value" => $dados["bairro"]));
echo $form->input("estado", array("type" => "select", "label" => "Estado", "options" => $optionsEstados, "div" => "grid-2-12", "value" => $dados["estado"]));
echo $form->input("cidade", array("type" => "select", "label" => "Cidade", "div" => "grid-10-12", "options" => array("Selecione o Estado"), "value" => $dados["cidade"]));
echo $form->input("fone", array("type" => "text", "alt" => "telefone", "label" => "Telefone", "div" => "grid-3-12", "value" => $dados["fone"]));
echo $form->input("fax", array("type" => "text", "alt" => "telefone", "label" => "Fax", "div" => "grid-3-12", "value" => $dados["fax"]));
echo $form->input("email", array("type" => "text", "label" => "E-mail", "div" => "grid-6-12", "value" => $dados["email"]));
echo $form->input("site", array("type" => "text", "label" => "Site", "div" => "grid-12-12", "value" => $dados["site"]));
echo $form->close("Salvar", array("class" => "formee-button"));
?>