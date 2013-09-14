<script type="text/javascript">
    $("button,.botao, input:submit, input:button, button", "html").button();
    $("input:text").setMask();

    $("#FormSysempresasId").change(function(){
        $("#FormFinanceirobancosId").load("/ferramentas/optionsBoletoBanco/"+$("#FormSysempresasId").val()+"/");
    });
    $("#FormFinanceirobancosId").load("/ferramentas/optionsBoletoBanco/"+$("#FormSysempresasId").val()+"/");
    $("#FormFinanceirobancosId").val("<?php echo $dadosForm["financeiroBancos_id"] ?>");



</script>
<?php
$this->pageTitle = "Financeiro :: Cobranças";
switch ($op) {
    case "novaCobranca":
        ?>
        <script type="text/javascript">

        </script>
        <?php
        echo $form->create("", array("id" => "FormRecebeBoleto"));
        echo $form->input("sysEmpresas_id", array("type" => "select", "options" => $empresas, "label" => "Cedente", "class" => "Form2Blocos", "value" => $dadosForm['sysEmpresas_id']));
        echo $form->input("comercialCliente_id", array("type" => "select", "options" => $clientes, "label" => "Sacado", "class" => "Form2Blocos", "value" => $dadosForm['comercialCliente_id']));
        echo $form->input("financeiroBancos_id", array("type" => "select", "label" => "Banco", "class" => "Form2Blocos", "value" => $dadosForm['financeiroBancos_id']));
        echo $form->input("numeroDoc", array("type" => "text", "label" => "N° Documento", "class" => "Form2Blocos", "value" => $dadosForm['numeroDoc']));
        echo $form->input("instrucoes", array("type" => "text", "label" => "Instrução do Boleto (Deduções, Observações...)", "class" => "Form2Blocos", "value" => $dadosForm['instrucoes']));
        ?>
        <script type="text/javascript" language="javascript">
            $("#addField").click(function(){
                var idDiv = geraID();
                $("#fields").append(//carrega esse campos no onclick
                "<div id='"+idDiv+"'>"+
                    "<div class='FormLeft' style='float:left; margin-right:2px;'><label>Valor</label><input type='text' name='valorBoleto[]' size='7' alt='moeda'/></div>"+
                    "<div class='FormLeft' style='float:left; margin-right:2px;'><label>Dedução</label><input type='text' name='valorDeducao[]' size='7' alt='moeda'/></div>"+
                    "<div class='FormLeft' style='float:left; margin-right:2px;'><label>Status(pago)</label><select name='pago[]' >"+
                    "<option value='0' SELECTED>Não Pago</option>"+
                    "<option value='1'>Pago - Divergente</option>"+
                    "<option value='2'>Pago - Ok</option>"+
                    "</select></div>"+
                    "<label>Vecimento</label><input type='text' name='vencimento[]' size='7' alt='date' value='<?php echo date("d-m-Y") ?>'/>"+
                    //"<label>Pagamento</label><input type='text' name='dtPagamento[]' size='10' alt='date'/>"+
                "<a href='javascript:void(0);' onClick='delDiv(\""+idDiv+"\");'><img src='/images/deletar.png' border='0'/></a></div>"
            );
                $("input:text").setMask();
            });
            $("#addField").trigger('click');


        </script>
        <?php
        echo "<fieldset>";
        echo "<legend>Vencimentos</legend>";
        echo "<div id='fields'></div>";

        echo $html->link("+", "javascript:void(0);", array("class" => "botao", "id" => "addField"));

        echo "</fieldset>";
        echo $form->close("Salvar", array("class"=>"botao"));

        break;
    case "editarCobranca":
        $comboStatusBoleto = array("0" => "Não Pago", "1" => "Pago - Divergente", "2" => "Pago - Ok");
        echo $form->create("", array("id" => "FormEditaBoleto"));
        echo $form->input("sysEmpresas_id", array("type" => "select", "options" => $empresas, "label" => "Cedente", "class" => "Form2Blocos", "value" => $dadosForm['sysEmpresas_id']));
        echo $form->input("comercialCliente_id", array("type" => "select", "options" => $clientes, "label" => "Sacado", "class" => "Form2Blocos", "value" => $dadosForm['comercialCliente_id']));
        echo $form->input("financeiroBancos_id", array("type" => "select", "label" => "Banco", "class" => "Form2Blocos", "value" => $dadosForm['financeiroBancos_id']));
        echo $form->input("numeroDoc", array("type" => "text", "label" => "N° Documento", "class" => "Form2Blocos", "value" => $dadosForm['numeroDoc']));
        echo $form->input("instrucoes", array("type" => "text", "label" => "Instrução do Boleto (Deduções, Observações...)", "class" => "Form2Blocos", "value" => $dadosForm['instrucoes']));
        echo $form->input("valorBoleto", array("type" => "text","div"=>"ladoalado", "alt" => "moeda", "label" => "V. do Boleto", "size" => "7", "value" => $dadosForm['valorBoleto']));
        echo $form->input("valorPago", array("type" => "text","div"=>"ladoalado", "alt" => "moeda", "label" => "V. Recebido", "size" => "7", "value" => $dadosForm['valorPago']));
        echo $form->input("vencimento", array("type" => "text","div"=>"ladoalado", "alt" => "date", "label" => "Vencimento", "size" => "7", "value" => $date->format("d-m-Y", $dadosForm['vencimento'])));
        echo $form->input("dtPagamento", array("type" => "text","div"=>"ladoalado", "alt" => "date", "label" => "Pagamento", "size" => "7", "value" => $date->format("d-m-Y", $dadosForm['dtPagamento'])));
        echo "<br clear='all'/>";
        echo $form->input("pago", array("type" => "select", "options" => $comboStatusBoleto, "label" => "Status", "class" => "Form2Blocos", "value" => $dadosForm['pago']));
        echo "<br clear='all'/>";
        echo $form->close("Salvar", array("class"=>"botao"));
        break;
    default:
    case "gridCobranca":
        echo $html->link("Todas", "/financeiro/receber/gridCobranca", array("class" => "botao"));
        echo $html->link("Nova Cobrança", "javascript:AbreJanela('/financeiro/receber/novaCobranca',500,500,'Nova Cobrança');", array("class" => "botao"));
        echo $html->link("Buscar Cobrança", "javascript:AbreJanela('/financeiro/receber/buscaCobranca',500,200,'Busca de Boletos');", array("class" => "botao"));
        echo $html->link("Inadimplentes", "/financeiro/receber/cobrancasAtrasadas", array("class" => "botao"));
        echo $html->link("Processar Pagamento", "javascript:AbreJanela('/financeiro/receber/processaPagamentoBoletos',500,200,'Processar Pagamento de Boletos');", array("class" => "botao"));

        echo "<br clear='all'/>";
        echo "<br/>";
        echo "<br/>";
        //echo $form->create("/financeiro/printBoleto");
        echo $xgrid->start($dadosGrid)
                ->caption("Lista de Cobranças")
                ->noData("Não há Cobranças com esse Critério")
                ->hidden(array("id", "valorDeducao", "instrucoes", "comercialCliente_id", "sysEmpresas_id", "financeiroBancos_id", "pago", "financeiroBancos_id", "created", "modified", "taxaBoleto", "nossoNumero", "numeroDoc"))
                // ->col('id')->checkbox('checado[]', '{id}')->title('')
                ->col("empresa")->cellArray("nomeFantasia")->title("Cedente")->position(1)
                ->col("cliente")->cellArray("nomeFantasia")->title("Sacado")->position(2)
                ->col("banco")->cellArray("banco", "nome")->position(3)
                ->col("valorPago")->title("V. Pago")->currency()
                ->col("valorBoleto")->title('Valor')->position(5)->conditions("pago", array("0" => array(), "1" => array("rowClass" => "pagoDivergente"), "2" => array("rowClass" => "pagoOk")))
                ->col("vencimento")->date('d/m/Y')->position(6)
                ->col("dtPagamento")->date('d/m/Y')->title("Compensado")->position(7)
                ->col("editar")->title("")->conditions("id", array(">=1" => array("label" => "editar.png", "href" => "javascript:popIn('janelaModal','/financeiro/receber/editarCobranca/{id}');", "border" => "0")))
                ->col("imprimir")->title("")->conditions("id", array(">=1" => array("label" => "icone_imprimir.gif", "href" => "/externo/verBoleto/{id}", "target" => "_blank", "border" => "0")))
                ->col('excluir')->title("")->conditions('pago', array(
                    ">=1" => array("label" => " "),
                    "<1" => array("label" => "deletar.png", "href" => "javascript:deletar('/financeiro/receber/delCobranca/{id}')", "border" => "0")
                ))
                ->alternate("grid_claro", "grid_escuro");
        //echo $form->close("Imprimir");
        //legend
        echo "<br/>";
        echo $html->image("npg.png");
        echo "Não Recebidas";
        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo $html->image("pgok.png");
        echo "Recebidas";
        //fim legenda
        break;
    case "cobrancasAtrasadas":
        echo $html->link("Todas", "/financeiro/receber/gridCobranca", array("class" => "botao"));
        echo $html->link("Nova Cobrança", "javascript:AbreJanela('/financeiro/receber/novaCobranca',500,500,'Nova Cobrança');", array("class" => "botao"));
        echo $html->link("Buscar Cobrança", "javascript:AbreJanela('/financeiro/receber/buscaCobranca',500,200,'Busca de Boletos');", array("class" => "botao"));
        echo $html->link("Inadimplentes", "/financeiro/receber/cobrancasAtrasadas", array("class" => "botao"));
        echo $html->link("Processar Pagamento", "javascript:AbreJanela('/financeiro/receber/processaPagamentoBoletos',500,200,'Processar Pagamento de Boletos');", array("class" => "botao"));

        echo "<br clear='all'/>";
        echo "<br/>";
        echo "<br/>";

        echo $xgrid->start($dadosGrid)
                ->caption("Lista de Cobranças")
                ->noData("Não há Cobranças com esse Critério")
                ->hidden(array("id", "valorDeducao", "instrucoes", "comercialCliente_id", "sysEmpresas_id", "financeiroBancos_id", "pago", "financeiroBancos_id", "created", "modified", "taxaBoleto", "nossoNumero", "numeroDoc"))
                ->col("empresa")->cellArray("nomeFantasia")->title("Cedente")->position(1)
                ->col("cliente")->cellArray("nomeFantasia")->title("Sacado")->position(2)
                ->col("banco")->cellArray("banco", "nome")->position(3)
                ->col("valorBoleto")->title('Valor')->position(5)->conditions("pago", array("0" => array(), "1" => array("rowClass" => "pagoDivergente"), "2" => array("rowClass" => "pagoOk")))
                ->col("vencimento")->date('d/m/Y')->position(6)
                ->col("dtPagamento")->hidden()
                ->col("editar")->title("")->conditions("id", array(">=1" => array("label" => "editar.png", "href" => "javascript:popIn('janelaModal','/financeiro/receber/editarCobranca/{id}');", "border" => "0")))
                ->col("imprimir")->title("")->conditions("id", array(">=1" => array("label" => "icone_imprimir.gif", "href" => "/externo/verBoleto/{id}", array("target" => "_blank", "border" => "0"))))
                ->col('excluir')->title("")->conditions('pago', array(
                    ">=1" => array("label" => " "),
                    "<1" => array("label" => "deletar.png", "href" => "javascript:deletar('/financeiro/receber/delCobranca/{id}')", "border" => "0")
                ))
                ->alternate("grid_claro", "grid_escuro")
                ->footer('valorBoleto')->sumReal()
                ->footer('valorPago')->sumReal();
        //legend
        echo "<br/>";
        echo $html->image("npg.png");
        echo "Não Recebidas";
        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo $html->image("pgok.png");
        echo "Recebidas";
        //fim legenda
        break;

    case "buscaCobranca":
        echo $form->create("/financeiro/receber/gridCobranca");
        $buscaBoleto = array("" => "Selecione...", "valorBoleto" => "Valor", "pago" => "Status", "numeroDoc" => "N° Documento");
        echo $form->input("field", array("type" => "select", "options" => $buscaBoleto, "label" => "Campo", "div" => "ladoalado", "class" => "Form1Bloco"));
        echo $form->input("value", array("type" => "text", "label" => "Valor", "class" => "Form1Bloco"));
        echo "<font size='-2px' color='#333'><i>'Para campo igual a Status <br/> 0 = não pago , 1 = pago - divergente , 2 = pago - ok'</i></font>";
        echo "<br/>";
        echo $form->close('Buscar',array("class"=>"botao"));
        break;

    case "processaPagamentoBoletos":
        if ($post) {
            echo "Atualizando.\n Aguarde....";
        } else {
            echo $form->create("", array("enctype" => "multipart/form-data"));
            echo $form->input("file", array("type" => "file", "label" => "Arquivo"));
            echo $form->close("Processar >>",array("class"=>"botao"));
        }
        break;
}
?>