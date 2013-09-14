<?php
// ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulário c/ POST, GET ou de BD (MySql,Postgre,etc)	//

// DADOS DO BOLETO PARA O SEU CLIENTE
echo $marketing->sortBanner(1);
$dias_de_prazo_para_pagamento = 5;
$taxa_boleto = $boleto["banco"]["taxaBoleto"];
$data_venc = $date->format("d/m/Y",$boleto["vencimento"]);  // Prazo de X dias  OU  informe data: "13/04/2006"  OU  informe "" se Contra Apresentacao;
$valor_cobrado =$boleto["valorBoleto"]; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

$dadosboleto["inicio_nosso_numero"] = "80";  // Carteira SR: 80, 81 ou 82  -  Carteira CR: 90 (Confirmar com gerente qual usar)
$dadosboleto["nosso_numero"] = $boleto["numeroDoc"];  // Nosso numero sem o DV - REGRA: Máximo de 8 caracteres!
$dadosboleto["numero_documento"] = $dadosboleto["nosso_numero"];	// Num do pedido ou do documento
$dadosboleto["data_vencimento"] = $date->format("d/m/Y",$boleto["vencimento"]); // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = $date->format("d/m/Y",$boleto["modified"]); // Data de emissão do Boleto
$dadosboleto["data_processamento"] = $date->format("d/m/Y",$boleto["modified"]); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

$dadosboleto["deducao"] = number_format($boleto["valorDeducao"],2,",",".");

$dadosboleto["localPagamento"] = $boleto["banco"]["localPagamento"];

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = $boleto["cliente"]["razaoSocial"];
$dadosboleto["endereco1"] = $boleto["cliente"]["endereco"];
$dadosboleto["endereco2"] = $boleto["cliente"]["cidade"]." - ".$optionsEstados[$boleto["cliente"]["estado"]] ." - ".$boleto["cliente"]["cep"] ;

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "";
$dadosboleto["demonstrativo2"] = "";
$dadosboleto["demonstrativo3"] = "";

// INSTRUÇÕES PARA O CAIXA
$dadosboleto["instrucoes1"] = "- {$boleto["banco"]["instrucoes1"]}";
$dadosboleto["instrucoes2"] = "- {$boleto["banco"]["instrucoes2"]}";
$dadosboleto["instrucoes3"] = "- {$boleto["banco"]["instrucoes3"]}";
$dadosboleto["instrucoesBoleto"] = "- {$boleto["instrucoes"]}";
$dadosboleto["instrucoes4"] = "&nbsp; Emitido pelo Sistema Integrado Assistec";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "";
$dadosboleto["valor_unitario"] = "";
$dadosboleto["aceite"] = "N";
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "DM";


// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


// DADOS DA SUA CONTA - CEF
$conta = explode("-",$boleto["banco"]["conta"]);
$dadosboleto["agencia"] = $boleto["banco"]["agencia"]; // Num da agencia, sem digito
$dadosboleto["conta"] = $conta[0]; 	// Num da conta, sem digito
$dadosboleto["conta_dv"] = $conta[1]; 	// Digito do Num da conta

// DADOS PERSONALIZADOS - CEF
$cedente = explode("-",$boleto["banco"]["cod_cedente"]);
$dadosboleto["conta_cedente"] = $cedente[1];// ContaCedente do Cliente, sem digito (Somente Números)
$dadosboleto["conta_cedente_dv"] = $cedente[2]; // Digito da ContaCedente do Cliente
$dadosboleto["codConvenio"] = $cedente[0];
$dadosboleto["carteira"] = "SR";  // Código da Carteira: pode ser SR (Sem Registro) ou CR (Com Registro) - (Confirmar com gerente qual usar)

// SEUS DADOS
$dadosboleto["identificacao"] = $boleto["banco"]["empresa"]["razaoSocial"];
$dadosboleto["cpf_cnpj"] = $boleto["banco"]["empresa"]["cnpj"];
$dadosboleto["endereco"] = $boleto["banco"]["empresa"]["endereco"];
$dadosboleto["cidade_uf"] = $boleto["banco"]["empresa"]["cidade"]." / ".$optionsEstados[$boleto["banco"]["empresa"]["estado"]] ." - ".$boleto["banco"]["empresa"]["cep"];
$dadosboleto["cedente"] = $boleto["banco"]["empresa"]["razaoSocial"];

// NÃO ALTERAR!
include("../helpers/boletos/funcoes_cef.php");
include("../helpers/boletos/layout_cef.php");
?>