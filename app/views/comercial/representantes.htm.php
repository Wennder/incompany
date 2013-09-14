<script type="text/javascript">
    $(document).ready(function() {
        $("button,.botao, input:submit, input:button, button", "html").button();
        $("input:text").setMask();
        
        $("#FormCidade").load("/integracao/options/sys_municipios/nome/<?php echo $dadosFormulario["cidade"] . "/uf/" . $dadosFormulario["estado_id"]; ?>");
        $("#FormEstadoId").change(function(){
                $("#FormCidade").load("/integracao/options/sys_municipios/nome/<?php echo "0" . "/uf/" ?>"+$("#FormEstadoId").val());
            });
            

        $("#novoRepresentante").validate({
            rules: {
                razaoSocial: {
                    required: true

                },
                nomeFantasia: {
                    required: true

                },
                cnpj: {
                    required: true

                },

                endereco: {
                    required: true

                },
                bairro: {
                    required: true

                },
                cep: {
                    required: true

                },

                cidade: {
                    required: true

                },
                estado: {
                    selectRequerido: 0

                },
                fone: {
                    required: true

                },
                email:{
                    required:true
                },
                grupoEmpresa_id:{
                    selectRequerido:0
                }
            },
            messages: {
                razaoSocial: {
                    required:"Informe a Razão Social!"

                },
                nomeFantasia: {
                    required: "Informe o Nome Fantasia!"

                },
                cnpj: {
                    required: "Informe o CNPJ!"

                },

                endereco: {
                    required: "Informe o Endereço!"

                },
                bairro: {
                    required: "Informe o Bairro!"

                },
                cep: {
                    required: "Informe o Cep!"

                },

                cidade: {
                    required: "Informe a Cidade!"

                },
                estado: {
                    selectRequerido: "Informe o Estado!"

                },
                fone: {
                    required: "Informe um Numero de Telefone!"

                },
                email:{
                    required:"Informe o E-mail!"
                },
                grupoEmpresa_id:{
                    selectRequerido:"Informe o Grupo de qual sua Empresa faz parte!"
                }
            }          

        });
    });
</script>
<?php
$this->pageTitle = "Comercial :: Representantes";
switch ($op) {
    default:
    case "grid":
        echo $xgrid->start($dadosGrid)
                ->caption("Representantes")
                ->alternate("grid_claro", "grid_escuro")
                ->col("id")->hidden()
                ->col("nomeFantasia")->title("Nome")->slice(30)
                ->col("editar")->title("")->cell("editar.gif", "javascript:loadDiv('#contComercial','/comercial/representantes/cadastrar/{id}')")
                ->col("deletar")->title("")->cell("deletar.png", "javascript:delAjax('/comercial/representantes/deletar/{id}','contComercial', '/comercial/representantes/grid');");

        break;
    case "cadastrar":
        echo $html->openTag("h3",array("class"=>"title"));
        echo "Representantes - {$dadosFormulario["nomeFantasia"]}";
        echo $html->closeTag("h3");
        echo $form->create("", array("id" => "novoRepresentante", "class" => "formee"));
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
        echo $form->input("estado_id", array("type" => "select", "label" => "Estado", "options" => $optionsEstados, "div" => "grid-2-12", "value" => $dadosFormulario["estado_id"]));
        echo $form->input("cidade", array("type" => "select", "label" => "Cidade", "div" => "grid-10-12", "options" => array("Selecione o Estado"), "value" => $dadosFormulario["cidade"]));
        echo $form->input("tel", array("type" => "text", "alt" => "telefone", "label" => "Telefone", "div" => "grid-3-12", "value" => $dadosFormulario["tel"]));
        echo $form->input("cel", array("type" => "text", "alt" => "telefone", "label" => "Fax", "div" => "grid-3-12", "value" => $dadosFormulario["cel"]));
        echo $form->input("email", array("type" => "text", "label" => "E-mail", "div" => "grid-6-12", "value" => $dadosFormulario["email"]));
        echo $form->input("site", array("type" => "text", "label" => "Site:", "div" => "grid-6-12", "value" => $dadosFormulario["site"]));
        echo $form->input("status", array("type" => "select", "label" => "Status", "options" => array("1" => "Ativo", "0" => "Desativado"), "div" => "grid-6-12", "value" => $dadosFormulario["status"]));
        echo "<br clear='all'/>";
        echo $form->close("Salvar", array("class" => "grid-2-12"));
        break;
}
?>
