<script>
	$(function(){
		$("button,.botao, input:submit, input:button, button", "html").button();
	});
</script>
<?php
$this->pageTitle = "Comercial :: Contratos";
switch ($op) {
    case"novo":
?>
        <script>
            $(function(){
                $("#contratos").tabs({
<?php
        if (empty($dadosContratos)) {
            echo "disabled:[1,2,3]";
        }
?>
                });

                $("#cadDocumento").dialog({
                    autoOpen: false,
                    modal:true,
                    height:300,
                    width:500,
                    beforeClose:function(){
                        $("#gridDocumentos").load("/comercial/docsContrato/<?php echo $dadosContratos['id'] ?>/grid");
                    }
                });
                $("#gridDocumentos").load("/comercial/docsContrato/<?php echo $dadosContratos['id'] ?>/grid");

                $("#cadAditamento").dialog({
                    autoOpen: false,
                    modal:true,
                    height:600,
                    width:750,
                    beforeClose:function(){
                        $("#gridAditamento").load("/comercial/aditamentos/<?php echo $dadosContratos['id'] ?>/grid");
                    }
                });
                $("#gridAditamento").load("/comercial/aditamentos/<?php echo $dadosContratos['id'] ?>/grid");

            });
        </script>
        
<?php echo $form->create(); ?>
        <div id="contratos">
            <ul>
                <li><a href="#dadosContrato">Dados do Contrato</a></li>
                <li><a href="#gerar">Gerar contrato</a></li>
                <li><a href="#aditamento">Aditamentos</a></li>
                <li><a href="#upload">Upload de Documentos</a></li>
            </ul>
            <div id="dadosContrato">
        <?php
        $periodicidade = array("Selecione...", "Anual", "Semestral", "Trimestral", "Bimestral", "Mensal", "Quinzenal", "Semanal", "Pagamento Único");
        $status = array("Selecione...", "1" => "Ativo", "2" => "Inativo");
        echo $form->input("prestadora", array("type" => "select", "options" => $comboPrestadoras, "class" => "Form2Blocos", "label" => "Empresa Prestadora", "value" => $dadosContratos["prestadora"]));
        echo $form->input("id_cliente", array("type" => "select", "options" => $comboClientes, "class" => "Form2Blocos", "label" => "Cliente", "value" => $dadosContratos["id_cliente"]));
        echo $form->input("id_gerente", array("type" => "select", "options" => $comboGerentes, "class" => "Form2Blocos", "label" => "Gerente", "value" => $dadosContratos["id_gerente"]));
        echo $form->input("id_tipo", array("type" => "select", "options" => $comboTipoContratos, "class" => "Form2Blocos", "label" => "Tipo de Contrato", "value" => $dadosContratos["id_tipo"]));
        echo $form->input("descricao", array("type" => "textarea", "rows" => "3", "cols" => "50", "label" => "Descrição", "value" => $dadosContratos["descricao"]));
        echo $form->input("valor", array("type" => "text", "alt" => "moeda", "class" => "Form1Bloco", "div" => "ladoalado", "label" => "Valor", "value" => $dadosContratos["valor"]));
        echo $form->input("periodicidadePgto", array("type" => "select", "options" => $periodicidade, "class" => "Form1Bloco", "label" => "Periodicidade de Pgto.", "value" => $dadosContratos["periodicidadePgto"]));
        echo $form->input("inicio", array("type" => "text", "alt" => "date", "class" => "Form1Bloco", "div" => "ladoalado", "label" => "Início", "value" => $date->format("d-m-Y", $dadosContratos["inicio"])));
        echo $form->input("vencimento", array("type" => "text", "alt" => "date", "class" => "Form1Bloco", "label" => "Vencimento", "value" => $date->format("d-m-Y", $dadosContratos["vencimento"])));
        echo $form->input("status", array("type" => "select", "options" => $status, "class" => "Form1Bloco", "label" => "Status", "value" => $dadosContratos["status"]));
        ?>
    </div>
    <div id="gerar">

        <a class="botao" id="loadContent" href="javascript:void(0);">Carregar Minuta</a>
        <script type="text/javascript">
            $("#loadContent").click(function(){
                if (confirm("Ao carregar o contrato todos os dados contidos anteriormente serão perdidos! \n Deseja carregar a minuta?")){
                    if($('#FormIdTipo').val()>0){
                        $.getJSON('/comercial/getMinutaTipoContrato/'+$('#FormIdTipo').val()+'/', function(data) {
                            CKEDITOR.instances.minutaText.setData(data['minuta']);
                        });
                    }else{
                        alert('Preencha o Tipo de Contrato');
                    }
                }
            });

        </script>
        <div id="minuta">
            <?php
            $optionEstados = array("Selecione...", "AC", "AL", "AP", "AM", "BA", "CE", "DF", "ES", "GO", "MA", "MT", "MS", "MG", "PA", "PB", "PR", "PE", "PI", "RJ", "RN", "RS", "RO", "RR", "SC", "SP", "SE", "TO");
            // pr($dadosContratos);
            //variaveis ambiente referente a empresa prestadora
            $vars["%nomeFantasiaPrestadora%"] = $dadosContratos["empresa"]["nomeFantasia"];
            $vars["%razaoSocialPrestadora%"] = $dadosContratos["empresa"]["razaoSocial"];
            $vars["%enderecoPrestadora%"] = $dadosContratos["empresa"]["endereco"] . " - " . $dadosContratos["empresa"]["cidade"] . "/" . $optionEstados[$dadosContratos["empresa"]["estado"]] . " - " . $dadosContratos["empresa"]["cep"];
            $vars["%cnpjPrestadora%"] = $dadosContratos["empresa"]["cnpj"];
            $vars["%cidadePrestadora%"] = $dadosContratos["empresa"]["cidade"];
            $vars["%iePrestadora%"] = $dadosContratos["empresa"]["ie"];
            //variaveis ambiente referente ao cliente
            $vars["%nomeFantasiaCliente%"] = $dadosContratos["cliente"]["nomeFantasia"];
            $vars["%razaoSocialCliente%"] = $dadosContratos["cliente"]["razaoSocial"];
            $vars["%enderecoCliente%"] = $dadosContratos["cliente"]["endereco"] . " - " . $dadosContratos["cliente"]["cidade"] . "/" . $optionEstados[$dadosContratos["cliente"]["estado"]] . " - " . $dadosContratos["empresa"]["cep"];
            $vars["%cnpjCliente%"] = $dadosContratos["cliente"]["cnpj"];
            $vars["%cidadeCliente%"] = $dadosContratos["cliente"]["cidade"];
            $vars["%ieCliente%"] = $dadosContratos["cliente"]["ie"];
            //variaveis ambientes referente ao contrato
            $vars["%inicioVigencia%"] = $date->format("d/m/Y", $dadosContratos["inicio"]);
            $vars["%valor%"] = $dadosContratos["valor"];
            $vars["%valorExtenso%"] = $financeiro->valorPorExtenso($dadosContratos["valor"]);
            $vars["%dataExtenso%"] = $date->dataExtenso($dadosContratos["inicio"]);


            foreach ($vars as $key => $value) {
                $dadosContratos["minuta"] = str_replace($key, $value, $dadosContratos["minuta"]);
            }
            echo $form->input("minuta", array("type" => "textarea", "id" => "minutaText", "class" => "editor", "value" => $dadosContratos["minuta"]));
            ?>
        </div>


    </div>
    <div id="aditamento">
        <a href="javascript:popIn('cadAditamento','/comercial/aditamentos/<?php echo $dadosContratos["id"]; ?>/novo/<?php echo $dadosAditamento['id']?>');" class="botao">*Novo</a>
        
        <div id="cadAditamento"></div>
        <div id="gridAditamento"></div>

    </div>
    <div id="upload">
        <a href="javascript:popIn('cadDocumento','/comercial/docsContrato/<?php echo $dadosContratos["id"]; ?>/novo/<?php echo $contratoId; ?>');" class="botao">*Novo</a>
        <br/>
        <div id="cadDocumento"></div>
        <div id="gridDocumentos"></div> 

    </div>
</div>
<?php
            echo $form->close("Registrar");
            break;

        case"grid":
            echo $xgrid->start($gridContrato)
                    ->caption("Lista de Contratos")
                    ->noData('Nehum registro encontrado!')
                    ->col("id_cliente")->hidden()
                    ->col("id_gerente")->hidden()
                    ->col("id_tipo")->hidden()
                    ->col("status")->hidden()
                    ->col("descricao")->hidden()
                    ->col("id")->title("Cod.")
                    ->col("empresa")->hidden()
                    ->col("cliente")->title("Cliente")->cellArray("nomeFantasia")->position(1)
                    ->col("gerente")->title("Gerente")->cellArray("nome")->position(2)
                    ->col("tipo_contrato")->title("Tipo")->cellArray("nome")
                    ->col("aditamento")->cellArray("valor")->hidden()
                    ->col("valor")->currency()
                    ->col("vencimento")->title("Vencimento")->date("d/m/Y")
                    ->col("Editar")->title("")->cell("editar.gif","javascript:loadDiv('#contComercial','/comercial/contratos/novo/{id}');")
                    ->col("excluir")->title("")->conditions("deletar.png","delAjax('/comercial/contratos/deletar/{id}','contComercial', '/comercial/contratos/grid')")
                    ->footer('valor')->sumReal()
                    ->alternate("grid_claro", "grid_escuro");
            echo $html->link("Novo Contrato", "javascript:loadDiv('#contComercial','/comercial/contratos/novo');", array("class" => "botao"));


            break;
        case "dashboard":

            break;
        case "buscar":
        ?>
        
        <?php
            echo $form->create("/comercial/contratos/grid");
            echo $form->input("field", array("type" => "select", "class" => "Form1Bloco", "div" => "ladoalado", "label" => "Campo", "options" => array("id" => "Cód. Contrato", "id_cliente" => "Cód. Cliente", "id_gerente" => "Cód. Gerente", "valor >=" => "Valor Maior que")));
            echo $form->input("data", array("label" => "Valor", "class" => "Form1Bloco"));
            echo $form->close("Buscar",array("class"=>"botao"));
            break;
        case "print":
            $pdf->AliasNbPages();
            $pdf->AddPage();
            $pdf->SetFont('helvetica', '', 12);
            for ($i = 1; $i <= 40; $i++)
                $pdf->Cell(0, 10, 'Printing line number ' . $i, 0, 1);
            $pdf->Output();
            break;
    }
?>