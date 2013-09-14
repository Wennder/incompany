<?php
switch($op){
    case "formConsulta":
        echo $html->openTag("center");
        echo $form->create("/externo/consultaBoleto/gridConsulta");
        echo $form->input("cnpj",array("label"=>"CPF / CNPJ (ex: 00.000.000/0001-00)","class"=>"Form2Blocos"));
        echo $form->close("Buscar");
        echo $html->closeTag("center");
        break;
    case "gridConsulta":
        echo $xgrid->start($dadosGrid)
            ->caption("Boletos Emitidos para o CNPJ: $cnpj")
            ->alternate("grid_claro","grid_escuro")
            ->noData("Não foi encontrado nenhum boleto registrado para esse CNPJ")
            ->hidden(array("id","sysEmpresas_id","comercialCliente_id","valorPago","dtPagamento","financeiroBancos_id","instrucoes","nossoNumero","pago","banco","taxaBoleto","created","modified"))
            ->col("cliente")->cellArray("razaoSocial")->title("Sacado")
            ->col("empresa")->cellArray("razaoSocial")->title("Cedente")
            ->col("vencimento")->date("d/m/Y")
            ->col("valorBoleto")->title("Valor")->currency()
            ->col("")->cell("icone_imprimir.gif","/externo/verBoleto/{id}",array("border"=>"0"));
        echo $html->link("Voltar","/externo/consultaBoleto/formConsulta",array("class"=>"botao"));
        break;
}
?>