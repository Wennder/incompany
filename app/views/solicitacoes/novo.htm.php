<script type="text/javascript">
    $(document).ready(function() {
    $("button,.botao, input:submit, input:button, button", "html").button();
    $("input:text").setMask();
        $("#novoSolicitacao").validate({
           rules: {
                beneficiario: {
                    selectRequerido:0
                },
                tipodespesa_id: {
                    selectRequerido:0
                },
                motivodespesa_id: {
                    selectRequerido:0
                },
                valor: {
                    selectRequerido:0
                }
            },
            messages: {
                beneficiario: {
                    selectRequerido:"Selecione o Beneficiario."
                },
                tipodespesa_id: {
                    selectRequerido:"Selecione o Tipo de despesa."
                },
                motivodespesa_id: {
                    selectRequerido:"Selecione o motivo da despesa."
                },
                valor: {
                    selectRequerido: "O valor deve ser maior que R$0,00."
			
                }
            }
        });
    });


</script>
    <?php
    echo $form->create("", array("id" => "novoSolicitacao"));
    echo $form->input("usuario_id", array("type" => "hidden", "value" => $loggedUser["id"]));
    echo $form->input("beneficiario", array("type" => "select", "label" => "Beneficiário", "class" => "Form2Blocos", "options" => $beneficiarios));
    echo $form->input("tipodespesa_id", array("type" => "select", "label" => "Tipo de Despesa", "class" => "Form2Blocos", "options" => $tiposDespesa));
    echo $form->input("motivodespesa_id", array("type" => "select", "label" => "Motivo da Despesa", "class" => "Form1Bloco", "div" => "ladoalado", "options" => $motivosDespesas));
    echo $form->input("os", array("type" => "text", "label" => "OS", "class" => "Form1Bloco"));
    echo $form->input("km", array("type" => "text", "label" => "KM", "class" => "Form1Bloco"));
    echo $form->input("valor", array("type" => "text", "label" => "Valor R$", "class" => "Form1Bloco", "div" => "ladoalado", "alt" => "moeda"));
    echo $form->input("nota", array("type" => "text", "label" => "Nota", "class" => "Form1Bloco"));
    echo $form->input("observacao", array("type" => "textarea", "label" => "Observação", "class" => "Form2Blocos", "rows" => "5"));
    echo "<br><center>";
    echo "Verifique bem os dados antes de envia-los<br>";
    echo $form->close("Gerar");
    echo "</center>";
    ?>