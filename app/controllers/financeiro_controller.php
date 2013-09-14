<?php

class financeiroController extends AppController {

    public $uses = array(
        "ocorrencia",
        "sys_empresas",
        "financeiro_motivodespesa",
        "tipodespesa",
        "financeiro_bancos",
        "financeiro_config_fp",
        "financeiro_conf_boleto",
        "financeiro_cobranca_boleto"
    );

    public function index() {
        
    }

    public function reembolsos() {

        if (empty($this->data)) {

            $where = array(
                "conditions" => array(
                    "status_id" => 1
                ),
                "fields" => array(
                    "id",
                    "beneficiario",
                    "created",
                    "valor",
                    "status_id",
                    "modified"
                ),
                "order" => "beneficiario, created"
            );
        } else {
            $this->data["dataInicio"] = $this->FormComponent->dataMysql($this->data["dataInicio"]);
            $this->data["dataFim"] = $this->FormComponent->dataMysql($this->data["dataFim"]);
            if (!empty($this->data["gerente"])) {
                $condicaoGerente = array(
                    "or" => array(
                        "usuario_id" => $this->data["gerente"],
                        "beneficiario" => $this->data["gerente"],
                        "gerente" => $this->data["gerente"]
                    ),
                    "and" => array(
                        "created >=" => $this->data["dataInicio"],
                        "created <=" => $this->data["dataFim"]
                    )
                );
            }

            $where = array(
                "conditions" => array(
                    "status_id" => $this->data["status"]
                ),
                "fields" => array(
                    "id",
                    "beneficiario",
                    "created",
                    "valor",
                    "modified",
                    "status_id"
                ),
                "order" => "modified DESC"
            );


            $where["conditions"] = array_merge($where["conditions"], $condicaoGerente);
        }
        $this->set("aPagar", $this->ocorrencia->all($where));
        $this->set("funcionarios", $this->FormComponent->funcionariosAtivos($this->AuthComponent->user("id"), "list"));

        //pr($where);
    }

    public function editarReembolso($id = null) {

        if (!empty($this->data)) {
            $this->data["pagoPor"] = $this->AuthComponent->user("id");
            $this->ocorrencia->save($this->data);
            $this->redirect("/financeiro/editarReembolso");
        }
        $whereOcorrencia = array(
            "conditions" => array(
                "id" => $id
                ));
        $this->set("Aocorrencia", $this->ocorrencia->first($whereOcorrencia));
    }

    public function motivoDespesa() {
        if (!empty($this->data)) {
            if (!$this->financeiro_motivodespesa->save($this->data)) {
                $this->set("mensagens", "Ocorreu algum erro na sua requisição no Banco de Dados Tente novamente, ou contacte o Administrador do sistema.");
            }
        }

        $where = array(
            "order" => "nome ASC"
        );
        $this->set("dadosMotivos", $this->financeiro_motivodespesa->all($where));
    }

    public function delMotivo($id) {
        $dados["id"] = $id;
        $dados["ativo"] = 0;
        $this->financeiro_motivodespesa->save($dados);
        $this->redirect("/financeiro/motivoDespesa");
    }

    public function tipoDespesa() {
        if (!empty($this->data)) {
            if (!$this->tipodespesa->save($this->data)) {
                $this->set("mensagens", "Ocorreu algum erro na sua requisição no Banco de Dados Tente novamente, ou contacte o Administrador do sistema.");
            }
        }

        $where = array(
            "order" => "nome ASC"
        );
        $this->set("dadosTipos", $this->tipodespesa->all($where));
    }

    public function delTipo($id) {
        $dados["id"] = $id;
        $dados["ativo"] = 0;
        $this->tipodespesa->save($dados);
        $this->redirect("/financeiro/tipoDespesa");
    }

    public function relDespesaReembolso() {
//$this->layout="relatorio";
        $where = array(
            "conditions" => array(
                "status_id" => 1
            ),
            "fields" => array(
                "id",
                "beneficiario",
                "created",
                "valor",
                "observacao",
                "obsGerente",
                "status_id",
                "tipodespesa_id",
                "motivodespesa_id"
            ),
            "order" => "beneficiario, created"
        );

        $this->set("aPagar", $this->ocorrencia->all($where));
    }

    public function acaoReembolso() {
        if (!empty($this->data)) {
            foreach ($this->data["checado"] as $mudar) {
                $dado["id"] = $mudar;
                $dado["pagoPor"] = $this->AuthComponent->user("id");
                $dado["status_id"] = $this->data["acao"];
                $this->ocorrencia->save($dado);
                unset($dado);
            }
            $this->redirect("/financeiro/relatorios/impressaoLoteReembolso/" . date("Y-m-d"));
        }
    }

    public function bancos() {
        if (!empty($this->data)) {
            $this->financeiro_bancos->save($this->data);
        }

        $this->set("dadosBancos", $this->financeiro_bancos->all(array("order" => "nome ASC")));
    }

    public function delBanco($id) {
        $this->financeiro_bancos->delete($id);
        $this->redirect("/financeiro/bancos");
    }

    public function configFolhaPagamento($op = 'grid', $id = null) {
        $this->set("op", $op);
        switch ($op) {
            case "novo":
                if (!empty($this->data)) {
                    $this->data['id'] = $id;
                    if ($this->financeiro_config_fp->save($this->data)) {
                        $this->setAlert("Registro efetuado com Sucesso!");
                        $this->redirect("/financeiro/configFolhaPagamento/grid");
                    } else {
                        $this->setAlert("Não foi possivel realizar sua requsição, tente novamente!");
                        $this->redirect("/financeiro/configFolhaPagamento/grid");
                    }
                }
                $this->set("dadosForm", $this->financeiro_config_fp->firstById());
                break;
            case "novoINSS":

                break;
            case "gridINSS":

                break;
            case "delINSS":

                break;
            case "grid":
                $this->set("dadosGrid", $this->financeiro_config_fp->all(array("order" => "id ASC")));
                break;
            case "deletar":
                $this->financeiro_config_fp->delete($id);
                break;
        }
    }

    public function relatorios($op, $id) {
        $this->set("op", $op);

        switch ($op) {
            case "movimentoReembolso":
                $diaMin = mktime(0, 0, 0, date("m"), date("d"), date("Y") - 1);
                $diaMin = date("Y-m", $diaMin);
                $hoje = date("Y-m-d");
                $condicao = array(
                    "conditions" => array(
                        "status_id" => "3"
                    ),
                    "groupBy" => "month(modified)",
                    "fields" => "sum(valor) as valor,month(modified) as mes,year(modified) as ano,gerente,tipodespesa_id,motivodespesa_id"
                );

                $this->set("dadosGrafico", $this->ocorrencia->all($condicao));

                $condicao["groupBy"] = "tipodespesa_id";
                $this->set("dadosPorTipo", $this->ocorrencia->all($condicao));

                $condicao["groupBy"] = "motivodespesa_id";
                $this->set("dadosPorMotivo", $this->ocorrencia->all($condicao));

                $condicao["groupBy"] = "gerente";
                $this->set("funcionarios", $this->rh_funcionarios->toList(array("displayField" => "nome")));
                $this->set("dadosPorGerente", $this->ocorrencia->all($condicao));
                break;
            case "selecionaDataLoteReembolso":
                if (!empty($this->data)) {
                    $this->redirect("/financeiro/relatorios/impressaoLoteReembolso/" . $this->data["data"]);
                }
                break;
            case "impressaoLoteReembolso":
                $condicao = array(
                    "conditions" => array(
                        "status_id" => "3",
                        "modified LIKE" => $id . "%"
                    ),
                    "groupBy" => "beneficiario",
                    "fields" => array(
                        "sum(valor) as valorTotal",
                        "beneficiario",
                        "gerente",
                        "pagoPor"
                    )
                );
                $this->set("dadosRelatorio", $this->ocorrencia->all($condicao));
                break;
        }
    }

    public function configBoleto($op = "grid", $id) {
        $this->set("op", $op);
        switch ($op) {
            case "novo":
                if (!empty($this->data)) {
                    $this->data["id"] = $id;
                    if ($this->financeiro_conf_boleto->save($this->data)) {
                        $this->setAlert("Salvo com sucesso");
                        $this->redirect("/financeiro/configBoleto");
                    } else {
                        $this->setAlert("Ocorreu algum erro, tente novamente.");
                        $this->redirect("/financeiro/configBoleto");
                    }
                }
                $this->set("dadosForm", $this->financeiro_conf_boleto->firstById($id));
                $condicao = array(
                    "conditions" => array(
                        "grupoEmpresa_id" => $this->AuthComponent->user("grupoEmpresa_id")
                    ),
                    "displayField" => "nomeFantasia",
                    "order" => "nomeFantasia ASC"
                );
                $this->set("empresas", $this->sys_empresas->toList($condicao));
                $this->set("bancos", $this->financeiro_bancos->toList(array("displayField" => "nome", "order" => "nome ASC")));
                break;
            case "grid":
                $this->set("dadosGrid", $this->financeiro_conf_boleto->all());
                break;
            case "deletar":
                $this->financeiro_conf_boleto->delete($id);
                $this->redirect("/financeiro/configBoleto");
                break;
        }
    }

    public function receber($op, $id) {
        $this->set("op", $op);
        switch ($op) {
            case "novaCobranca":
                if (!empty($this->data)) {
                    $enviado = $this->data;
                    //pr($enviado);
                    $num = 0;

                    foreach ($enviado["valorBoleto"] as $key => $value) {
                        $num++;
                        $nossoNumero = str_pad($enviado["numeroDoc"], 7, 0, STR_PAD_LEFT);
                        $nossoNumero = str_pad($enviado["numeroDoc"], 8, $num, STR_PAD_RIGHT);
                        $dados[] = array(
                            "sysEmpresas_id" => $enviado["sysEmpresas_id"],
                            "comercialCliente_id" => $enviado["comercialCliente_id"],
                            "financeiroBancos_id" => $enviado["financeiroBancos_id"],
                            "valorBoleto" => $value,
                            "valorDeducao" => $enviado["valorDeducao"][$key],
                            "numeroDoc" => $enviado["numeroDoc"],
                            "nossoNumero" => $nossoNumero,
                            "instrucoes" => $enviado["instrucoes"],
                            "pago" => $enviado["pago"][$key],
                            "vencimento" => $this->FormComponent->dateFormat("Y-m-d", $enviado["vencimento"][$key])
                        );
                    }
                    $this->financeiro_cobranca_boleto->saveAll($dados);
                    $this->redirect("/financeiro/receber/gridCobranca");
                }

                $condicao = array(
                    "conditions" => array(
                        "grupoEmpresa_id" => $this->AuthComponent->user("grupoEmpresa_id")
                    ),
                    "displayField" => "nomeFantasia",
                    "order" => "nomeFantasia ASC"
                );
                $this->set("dadosForm", $this->financeiro_cobranca_boleto->firstById($id));
                $this->set("empresas", $this->sys_empresas->toList($condicao));
                $idEmpFuncionario = $this->AuthComponent->user("sysEmpresas_id");
                $this->set("clientes", $this->comercial_clientes->toList(array("displayField" => "razaoSocial", "order" => "razaoSocial ASC")));
                break;
            case "editarCobranca":
                if (!empty($this->data)) {
                    $this->data["id"] = $id;
                    $this->data["vencimento"] = $this->FormComponent->dateFormat("Y-m-d", $this->data["vencimento"]);
                    $this->data["dtPagamento"] = $this->FormComponent->dateFormat("Y-m-d", $this->data["dtPagamento"]);
                    $this->financeiro_cobranca_boleto->save($this->data);
                    $this->redirect("/financeiro/receber/gridCobranca");
                }
                $condicao = array(
                    "conditions" => array(
                        "grupoEmpresa_id" => $this->AuthComponent->user("grupoEmpresa_id")
                    ),
                    "displayField" => "nomeFantasia",
                    "order" => "nomeFantasia ASC"
                );

                $this->set("dadosForm", $this->financeiro_cobranca_boleto->firstById($id));
                $this->set("empresas", $this->sys_empresas->toList($condicao));
                $idEmpFuncionario = $this->AuthComponent->user("sysEmpresas_id");
                $this->set("clientes", $this->comercial_clientes->toList(array("displayField" => "razaoSocial", "order" => "razaoSocial ASC")));
                break;
            case "cobrancasAtrasadas":
                $condicao = array(
                    "conditions" => array(
                        "pago" => "0",
                        "vencimento <" => date("Y-m-d")
                    )
                );
                $this->set("dadosGrid", $this->financeiro_cobranca_boleto->all($condicao));
                break;
            default:
            case "gridCobranca":
                if (!empty($this->data) && $this->data["value"] != "") {
                    $condicao = array(
                        "conditions" => array(
                            $this->data["field"] => $this->data["value"]
                        )
                    );
                    $this->set("dadosGrid", $this->financeiro_cobranca_boleto->all($condicao));
                } else {
                    $this->set("dadosGrid", $this->financeiro_cobranca_boleto->all(array("order" => "modified DESC")));
                }

                break;
            case "delCobranca":
                $this->financeiro_cobranca_boleto->delete($id);
                $this->redirect("/financeiro/receber/gridCobranca");
                break;
            case "processaPagamentoBoletos":
                $this->layout = false;

                if (!empty($this->data)) {
                    $this->set("post", true);
                    $this->UploadComponent->path = "/images/financeiro/logBoletos/";
                    $file = $this->UploadComponent->files["file"]; //o erro praticamente estava aqui
                    $filename = $this->AuthComponent->createPassword() . "." . $this->UploadComponent->ext($file);
                    $upload = $this->UploadComponent->upload($file, null, $filename);
                    $arq = "images/financeiro/logBoletos/" . $filename;
                    if ($upload) {

                        $handle = fopen($arq, "r");
                        if ($handle) {
                            $qtd = 0;
                            $linhas = 1;
                            $boletos = 0;
                            $processados = 0;
                            while (($buffer = fgets($handle, 4096)) !== false) {
                                if ($qtd > 1) {
                                    if (($linhas % 2) == 0) {
                                        $salvar["valorPago"] = $this->FormComponent->formatarValorBoleto(substr($buffer, 77, 15));
                                        if (trim($salvar["valorPago"]) > 0) {
                                            $save = true;
                                            $boletos++;
                                        }
                                        $salvar["valorDeducao"] = $this->FormComponent->formatarValorBoleto(substr($buffer, 47, 15));
                                        $salvar["valorPago"] = $this->FormComponent->formatarvalorBoleto(substr($buffer, 92, 15));
                                        $salvar["dtPagamento"] = $this->FormComponent->formatarDataBoleto(substr($buffer, 145, 8));

                                        if ($save) {
                                            //pr($salvar);
                                            $boleto = $this->financeiro_cobranca_boleto->first(array("conditions" => array("pago" => "0", "numeroDoc" => $salvar["numeroDoc"])));
                                            if ($boleto["id"] > 0) {
                                                $salvar["id"] = $boleto["id"];
                                                if ((($boleto["valorBoleto"] - $salvar["valorDeducao"]) - $salvar["valorPago"]) > 5) {
                                                    $salvar["pago"] = 1;
                                                } else {
                                                    $salvar["pago"] = 2;
                                                }
                                                unset($salvar["valorDeducao"]);
                                                if ($this->financeiro_cobranca_boleto->save($salvar)) {
                                                    $processados++;
                                                }
                                            }
                                        }
                                        unset($salvar);
                                        unset($save);
                                    } else {
                                        $salvar["numeroDoc"] = substr($buffer, 49, 7);
                                    }
                                    $linhas++;
                                }
                                $qtd++;
                            }
                            if (!feof($handle)) {
                                echo "Error: unexpected fgets() fail\n";
                            }
                            fclose($handle);
                        }
                        unlink($arq);
                        echo "<script>alert(\"Boletos no Retorno: $boletos | Boletos Pagos: $processados\"); history.go(-1);</script>";
                    }
                }
                break;
        }
    }

    public function nfe($op, $nota) {
        $this->set("op", $op);
        switch ($op) {
            default :
            case "grid":
                break;

            case "entradaImportacao":
                break;

            case "saidaImportacao":
                break;

            case "cancelar":
                break;

            case "produtosNota":
                break;
            case "getXml":
                break;

            case "novoVolume":
                break;
            
            case "gridVolumes":
                break;
            
            case "novaDuplicata":
                break;
            
            case "gridDuplicata":
                break;
        }
    }

}

?>