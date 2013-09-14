<?php

class importacoesController extends AppController {

    public $moduloID = "5";
    public $uses = array(
        "admin_config",
        "estoque_produtos",
        "estoque_transportadoras",
        "importacoes_agentescarga",
        "importacoes_anexos",
        "importacoes_operacoes",
        "importacoes_fabricantesprocesso",
        "importacoes_contratoscambio",
        "importacoes_custosfechamento",
        "importacoes_conteineres",
        "importacoes_status",
        "importacoes_processos",
        "importacoes_nacionalizacao",
        "importacoes_nomecustos",
        "importacoes_terminais",
        "importacoes_configterminais",
        "importacoes_produtos",
        "marketing_templateemails",
        "sys_moedas",
        "sys_ncm",
        "sys_cfop"
    );

    public function viewDadoImportacao($op, $processo, $campo = null) {
        $this->set("op", $op);
        $this->set("processo", $processo);
    }

    public function configStatus($op, $id) {
        $this->set("op", $op);

        switch ($op) {
            default:
            case "grid":
                $condicao = array(
                    "order" => "tipoPedido DESC, nome ASC"
                );
                $this->set("dadosGrid", $this->importacoes_status->all($condicao));
                break;
            case "cadastrar":
                if (!empty($this->data)) {
                    $this->data["id"] = $id;
                    $this->importacoes_status->save($this->data);
                }
                $this->set("dadosForm", $this->importacoes_status->firstbyId($id));
                break;
            case "deletar":
                $this->importacoes_status->delete($id);
                break;
        }
    }

    public function config_terminais($op, $id) {
        $this->set("op", $op);

        $condicao = array(
            "order" => "nome ASC"
        );

        switch ($op) {
            default:
            case "grid":
                $this->set("dadosGrid", $this->importacoes_terminais->all($condicao));
                break;
            case "grid_externo":
                $this->set("dadosGrid", $this->importacoes_terminais->all($condicao));
                break;
            case "cadastrar":
                if (!empty($this->data)) {
                    $this->data["id"] = $id;

                    $this->importacoes_terminais->save($this->data);
                }
                $this->set("dadosForm", $this->importacoes_terminais->firstById($id));
                break;
            case "deletar":
                $this->importacoes_terminais->delete($id);
                break;
        }
    }

    public function config_nomeCustos($op, $id) {
        $this->set("op", $op);

        switch ($op) {
            case "cadastrar":
                if (!empty($this->data)) {
                    $this->data["id"] = $id;
                    if ($this->importacoes_nomecustos->save($this->data)) {
                        die("Salvo com Sucesso");
                    } else {
                        die("Ocorreu algum erro, tente novamente");
                    }
                }
                $this->set("dadosForm", $this->importacoes_nomecustos->firstById($id));
                break;
            case "deletar":
                $this->importacoes_nomecustos->delete($id);

            default:
            case "grid":
                $condicao = array(
                    "order" => "nome ASC"
                );
                $this->set("dadosGrid", $this->importacoes_nomecustos->all($condicao));
                break;
        }
    }

    public function config_custosTerminais($op, $idTerminal, $id) {
        $this->set("op", $op);
        $this->set("idTerminal", $idTerminal);

        switch ($op) {
            default:
            case "grid":
                $condicao = array(
                    "conditions" => array(
                        "terminais_id" => $idTerminal
                    )
                );
                $this->set("dadosGrid", $this->importacoes_configterminais->all($condicao));
                break;
            case "cadastrar":
                if (!empty($this->data)) {
                    $this->data["id"] = $id;
                    $this->data["terminais_id"] = $idTerminal;
                    if ($this->importacoes_configterminais->save($this->data)) {
                        die("Salvo com Sucesso.");
                    } else {
                        die("Ocorreu Algum Erro Durante o Processo, Tente Novamente.");
                    }
                }
                $this->set("dadosForm", $this->importacoes_configterminais->firstById($id));
                break;
            case "deletar":
                $this->importacoes_configterminais->delete($idTerminal);
                break;
        }
    }

    public function configOperacoes($op, $id) {
        $this->set("op", $op);

        switch ($op) {
            default :
            case "grid":
                $condicao = array(
                    "fields" => array(
                        "id", "nomeOperacao", "modified"
                    )
                );
                $this->set("dadosGrid", $this->importacoes_operacoes->all($condicao));
                break;

            case "cadastrar":
                if (!empty($this->data)) {
                    $this->data["id"] = $id;
                    $this->importacoes_operacoes->save($this->data);
                    $this->redirect("/importacoes/");
                }
                $this->set("dadosFormulario", $this->importacoes_operacoes->firstById($id));
                break;

            case "deletar":
                $this->importacoes_operacoes->delete($id);
                $this->redirect("/importacoes/");
                break;
        }
    }

    public function despesasNacionalizacao($op, $processo, $id) {
        $this->set("op", $op);
        $this->set("processo", $processo);
        switch ($op) {
            case "grid":
            case "count":
                $condicao = array(
                    "conditions" => array(
                        "processo" => $processo
                    )
                );
                $this->set("dadosGrid", $this->importacoes_nacionalizacao->all($condicao));
                break;
            case "somaTotal":
                $condicao = array(
                    "conditions" => array(
                        "processo" => $processo
                    ),
                    "fields" => array("Format(sum(valorTotal),2) as soma")
                );

                $this->set("dadosGrid", $this->importacoes_nacionalizacao->first($condicao));
                break;
            case "cadastrar":
                if (!empty($this->data)) {
                    $custo = $this->importacoes_nomecustos->firstById($this->data["custo_id"]);
                    $condicao = array(
                        "conditions" => array(
                            "processo" => $processo
                        ),
                        "fields" => array("qtdContainer", "qtdCarretas")
                    );
                    $multiplicador = $this->importacoes_processos->first($condicao);

                    $multiplicador = array(
                        "0" => "1",
                        "1" => $multiplicador["qtdContainer"],
                        "2" => $multiplicador["qtdCarretas"]
                    );
                    $this->data["valorTotal"] = $this->data["valorUnitario"] * $multiplicador[$custo["multiplicacao"]];
                    $this->data["processo"] = $processo;
                    $this->importacoes_nacionalizacao->save($this->data);
                }
                break;
            case "deletar":
                $this->importacoes_nacionalizacao->delete($processo);
                break;
            case "setTerminal":
                if (!empty($this->data)) {

                    $condicaoProcesso = array(
                        "conditions" => array(
                            "processo" => $processo
                        )
                    );
                    $dadosProcesso = $this->importacoes_processos->first($condicaoProcesso);

                    $salvar["id"] = $dadosProcesso["id"];
                    $salvar["terminalAtraque"] = $this->data["terminalAtraque"];
                    $this->importacoes_processos->save($salvar);

                    $condicao = array(
                        "conditions" => array(
                            "processo" => $processo,
                            "auto" => "1"
                        )
                    );
                    $this->importacoes_nacionalizacao->deleteAll($condicao);

                    $condicaoCustos = array(
                        "conditions" => array(
                            "terminais_id" => $this->data["terminalAtraque"]
                        )
                    );
                    $custosTerminal = $this->importacoes_configterminais->all($condicaoCustos);

                    $condicao = array(
                        "conditions" => array(
                            "processo" => $processo
                        ),
                        "fields" => array("qtdContainer", "qtdCarretas")
                    );
                    $multiplicador = $this->importacoes_processos->first($condicao);

                    foreach ($custosTerminal as $custo) {
                        if ($custo["custo"]["multiplicacao"] == 0) {
                            $valorTotal = $custo["valorUnitario"];
                        } elseif ($custo["custo"]["multiplicacao"] == 1) {
                            $valorTotal = $custo["valorUnitario"] * $multiplicador["qtdContainer"];
                        } else {
                            $valorTotal = $custo["valorUnitario"] * $multiplicador["qtdCarretas"];
                        }
                        $custos[] = array(
                            "processo" => $processo,
                            "custo_id" => $custo["custo_id"],
                            "valorUnitario" => $custo["valorUnitario"],
                            "valorTotal" => $valorTotal,
                            "auto" => "1"
                        );
                    }
                    $this->importacoes_nacionalizacao->saveAll($custos);
                } else {
                    $condicao = array(
                        "displayField" => "nome"
                    );
                    $this->set("optTerminais", $this->importacoes_terminais->toList($condicao));

                    $condicao = array(
                        "conditions" => array(
                            "processo" => $processo
                        ),
                        "fields" => array("terminalAtraque")
                    );
                    $this->set("dadosForm", $this->importacoes_processos->first($condicao));
                }
                break;
        }
    }

    public function novoProcesso($op = "getId") {
        switch ($op) {
            default:
            case "getId":
                echo $this->importacoes_processos->getInsertId();
                break;
            case "newId":
                $processo = $this->ImportacoesComponent->novoProcesso();
                if (is_numeric($processo)) {
                    $this->redirect("/importacoes/orcamento/$processo");
                } else {
                    $this->setAlert("O processo não pôde ser criado.");
                    $this->redirect("/importacoes/");
                }
                break;
        }
    }

    public function setPedido($processo) {
        $save["id"] = substr($processo, 4);
        $save["tipoProcesso"] = "1";

        if ($this->importacoes_processos->save($save)) {
            $this->redirect("/importacoes/processo/$processo");
        } else {
            $this->setAlert("Houve algum erro ao tornar esse Orçamento em Pedido!");
            $this->redirect("/importacoes/");
        }
    }

    public function orcamento($processo) {
        if (!empty($this->data)) {
            $this->importacoes_processos->save($this->data);
        }
        $this->set("optMoedas", $this->sys_moedas->toList(array("displayField" => "nome", "order" => "nome ASC")));
        $this->processo($processo);
    }

    public function processo($processo, $data) {
        $this->set("tipoProcesso", array("Orçamento", "Pedido"));

        if (!empty($this->data)) {
            $this->data["dtPedidoCliente"] = $this->FormComponent->dataMysql($this->data["dtPedidoCliente"]);
            $this->data["eta"] = $this->FormComponent->dataMysql($this->data["eta"]);
            $this->data["etd"] = $this->FormComponent->dataMysql($this->data["etd"]);
            $this->data["dtInvoice"] = $this->FormComponent->dataMysql($this->data["dtInvoice"]);
            $this->data["dtProforma"] = $this->FormComponent->dataMysql($this->data["dtProforma"]);
            $this->data["dtLi"] = $this->FormComponent->dataMysql($this->data["dtLi"]);
            $this->data["dtDi"] = $this->FormComponent->dataMysql($this->data["dtDi"]);

            $this->importacoes_processos->save($this->data);
        }
        $dadosForm = $this->importacoes_processos->first(array("conditions" => array("processo" => $processo)));
        $condicaoOpt = array(
            "conditions" => array(
                "tipoPedido" => $dadosForm["tipoProcesso"]
            ),
            "displayField" => "nome",
            "order" => "nome"
        );
        $this->set("optStatus", $this->importacoes_status->toList($condicaoOpt));
        unset($condicaoOpt["conditions"]);
        $condicaoOpt["displayField"] = "nomeOperacao";
        $condicaoOpt["order"] = "nomeOperacao";
        $this->set("optOperacoes", $this->importacoes_operacoes->toList($condicaoOpt));
        $this->set("dadosForm", $dadosForm);
    }

    public function memorialCalculo($processo) {
        $this->set("optMoedas", $this->sys_moedas->toList(array("displayField" => "nome", "order" => "nome ASC")));
        $this->set("processo", $processo);

        $condicao = array(
            "fields" => array(
                "despachante", "moeda", "txCambio", "frete", "seguro", "thc", "taxaSiscomex",
                "qtdContainer", "qtdCarretas", "terminalAtraque", "enquadramento",
                "industrial", "lucroReal", "destinacao", "desconto"
            ),
            "conditions" => array(
                "processo" => $processo
            )
        );
        $this->set("dadosForm", $this->importacoes_processos->first($condicao));
    }

    public function fornecedoresProcesso($op, $processo, $id) {
        $this->set("op", $op);
        $this->set("processo", $processo);

        switch ($op) {
            default:
            case "grid":
                $condicao = array(
                    "conditions" => array(
                        "processo" => $processo
                    )
                );
                $this->set("dadosGrid", $this->importacoes_fabricantesprocesso->all($condicao));
                break;
            case "cadastrar":
                if (!empty($this->data)) {
                    $this->data["processo"] = $processo;
                    $this->data["id"] = $id;
                    $this->data["dtConfirmacao"] = $this->FormComponent->dataMysql($this->data["dtConfirmacao"]);
                    $this->data["dtProducao"] = $this->FormComponent->dataMysql($this->data["dtProducao"]);
                    $this->importacoes_fabricantesprocesso->save($this->data);
                }
                $this->set("dadosForm", $this->importacoes_fabricantesprocesso->firstById($id));
                break;
            case "deletar":
                $this->importacoes_fabricantesprocesso->delete($id);
                break;
        }
    }

    public function uploadDocumento($op, $processo, $id) {
        $this->set("processo", $processo);
        $this->set("op", $op);

        switch ($op) {
            default:
            case "grid":
                $condicao = array(
                    "conditions" => array(
                        "processo" => $processo
                    )
                );
                $this->set("dadosGrid", $this->importacoes_anexos->all($condicao));

                break;
            case "cadastrar":
                if (!empty($this->data)) {
                    $this->data["processo"] = $processo;
                    $this->data["id"] = $id;
                    $this->data["data"] = $this->FormComponent->dataMysql($this->data["data"]);

                    if ($this->data["file"]["size"] > 0) {
                        $this->UploadComponent->path = "/files/{$this->AuthComponent->user("empresa_id")}/importacoes/$processo/";
                        $file = $this->UploadComponent->files["file"]; //o erro praticamente estava aqui
                        $filename = $this->AuthComponent->createPassword() . "." . $this->UploadComponent->ext($file);
                        $upload = $this->UploadComponent->upload($file, null, $filename);
                        if (!$upload) {
                            die("<b>Erro:</b><br/>" + $this->UploadComponent->uploadError());
                        } else {
                            $this->data["arquivo"] = $this->UploadComponent->path . $filename;
                        }
                    }

                    if (!$this->importacoes_anexos->save($this->data)) {
                        die("Houve um problema em sua requisição, tente novamente");
                    } else {
                        die("Salvo com Sucesso!");
                    }
                }
                $this->set("dadosForm", $this->importacoes_anexos->firstById($id));
                break;
            case "deletar":
                if (!empty($id)) {
                    $url = $this->importacoes_anexos->firstById($id);
                    if (!empty($url["arquivo"])) {
                        if ($retorno = $this->UploadComponent->deleteFile($url["arquivo"])) {
                            $this->importacoes_anexos->delete($id);
                            die("Deletado com Sucesso");
                        } else {
                            die($retorno);
                        }
                    } else {
                        $this->importacoes_anexos->delete($id);
                        die("Deletado com Sucesso");
                    }
                }
                break;
        }
    }

    public function conteineres($op, $processo, $id) {
        $this->set("op", $op);
        $this->set("processo", $processo);
        switch ($op) {
            case "cadastrar":
                if (!empty($this->data)) {
                    $this->data["processo"] = $processo;
                    $this->data["id"] = $id;
                    $this->importacoes_conteineres->save($this->data);
                }

                $condicao = array(
                    "displayField" => "nomeFantasia",
                    "order" => "nomeFantasia ASC",
                );

                $this->set("optTransportadoras", $this->estoque_transportadoras->toList($condicao));

                $this->set("dadosForm", $this->importacoes_conteineres->firstById($id));
                $modalidadeEmbarque = $this->importacoes_processos->first(array("conditions" => array("processo" => $processo), "fields" => array("tipoEmbarque")));
                $this->set("tipoEmbarque", $modalidadeEmbarque);
                break;
            case "importar":
                if (!empty($this->data)) {
                    $this->set("armador", $this->data["armador"]);
                    $this->set("processo", $processo);
                    $this->set("dadosGrid", $this->TrackingComponent->importConteiner($this->data["armador"], $this->data["documento"]));
                    if (is_array($this->data["transportadora_id"])) {
                        foreach ($this->data["numero"] as $key => $value) {
                            $dadosSave[] = array(
                                "transportadora_id" => $this->data["transportadora_id"][$key],
                                "processo" => $this->data["processo"][$key],
                                "numero" => $this->data["numero"][$key],
                                "lacre" => $this->data["lacre"][$key],
                                "tipoConteiner" => $this->data["tipoConteiner"][$key]
                            );
                            if ($this->importacoes_conteineres->saveAll($dadosSave)) {
                                die("Salvo com Sucesso");
                            }
                        }
                    }
                }
                $condicao = array(
                    "displayField" => "nomeFantasia",
                    "order" => "nomeFantasia ASC",
                );

                $this->set("optTransportadoras", $this->estoque_transportadoras->toList($condicao));

                $condicaoDocumentos = array(
                    "conditions" => array(
                        "processo" => $processo
                    ),
                    "fields" => array(
                        "nMaster",
                        "nHouse",
                        "codRastreio"
                    )
                );
                $this->set("optDocumentos", $this->importacoes_processos->first($condicaoDocumentos));

                break;
            case "deletar":
                $this->importacoes_conteineres->delete($id);
                break;
            default:
            case "grid":
                $condicao = array(
                    "conditions" => array(
                        "processo" => $processo
                    )
                );
                $this->set("dadosGrid", $this->importacoes_conteineres->all($condicao));
                break;
        }
    }

    public function tracking($op, $processo = null, $idTracking = null) {
        switch ($op) {
            case "track":

                break;
            default:
            case "alertaAtracacao":
                if (!empty($this->data)) {
                    
                }
                break;
        }
        $this->TrackingComponent->trackingMsc(array("trackingCode" => "MSCUBP434729"));
        $this->TrackingComponent->updateEta($processo);
    }

    public function contratosCambio($op, $processo, $id) {
        $this->set("processo", $processo);
        $this->set("op", $op);
        $this->set("optMoedas", $this->sys_moedas->toList(array("displayField" => "nome", "order" => "nome ASC")));
        switch ($op) {
            default:
            case "grid":
                $condicao = array(
                    "conditions" => array(
                        "processo" => $processo
                    ),
                    "order" => "data ASC"
                );
                $this->set("dadosGrid", $this->importacoes_contratoscambio->all($condicao));

                break;
            case "cadastrar":
                if (!empty($this->data)) {
                    $this->data["processo"] = $processo;
                    $this->data["data"] = $this->FormComponent->dataMysql($this->data["data"]);
                    $this->importacoes_contratoscambio->save($this->data);
                }
                break;
            case "deletar":
                $this->importacoes_contratoscambio->delete($id);
                break;
        }
    }

    public function custosFechamento($op, $processo, $tipo) {
        $tipos = array("Debito", "Crédito");
        $this->set("op", $op);
        $this->set("tipo", $tipos[$tipo]);
        $this->set("optTipos", $tipos);
        $this->set("processo", $processo);

        switch ($op) {
            default :
            case "grid":
                $condicao = array(
                    "conditions" => array(
                        "processo" => $processo
                    ),
                    "order" => "credito DESC, data ASC"
                );
                $this->set("dadosGrid", $this->importacoes_custosfechamento->all($condicao));
                break;
            case "cadastrar":
                if (!empty($this->data)) {
                    $this->data["processo"] = $processo;
                    $this->data["credito"] = $tipo;
                    if ($tipo == 0) {
                        $this->data["valor"] = $this->data["valor"] * (-1);
                    }
                    $this->data["data"] = $this->FormComponent->dataMysql($this->data["data"]);
                    $this->importacoes_custosfechamento->save($this->data);
                }
                break;

            case "despesas":
                $condicao = array(
                    "conditions" => array(
                        "processo" => $processo
                    )
                );
                $despesas = $this->importacoes_nacionalizacao->all($condicao);

                foreach ($despesas as $despesa) {
                    $dado[] = array(
                        "processo" => $processo,
                        "descricao" => $despesa["custo"]["nome"],
                        "data" => $despesa["created"],
                        "valor" => $despesa["valorTotal"] * -1,
                        "credito" => "0"
                    );
                }
                $this->importacoes_custosfechamento->saveAll($dado);
                break;

            case "impostos":
                $condicaoProcesso = array(
                    "conditions" => array(
                        "processo" => $processo
                    ),
                    "fields" => array(
                        "dtDi"
                    )
                );
                $dataDi = $this->importacoes_processos->first($condicaoProcesso);
                $condicao = array(
                    "conditions" => array(
                        "processo" => $processo
                    ),
                    "fields" => array(
                        "sum(ii) as ii",
                        "sum(ipiEntrada) as ipi",
                        //"sum(icmsEntra) as icms",
                        "sum(pis) as pis",
                        "sum(cofins) as cofins",
                        "sum(taxaSiscomex) as taxa_siscomex"
                    ),
                    "groupBy" => "processo"
                );
                $impostos = $this->importacoes_produtos->first($condicao);

                foreach ($impostos as $imposto => $valor) {
                    if ($valor > 0 && $imposto != "estoque_produtos") {
                        $dado[] = array(
                            "processo" => $processo,
                            "descricao" => "PAGAMENTO DE IMPOSTO - " . strtoupper($imposto),
                            "data" => $dataDi["dtDi"],
                            "valor" => $valor * -1,
                            "credito" => "0"
                        );
                    }
                }
                $this->importacoes_custosfechamento->saveAll($dado);
                break;

            case "deletar":
                $this->importacoes_custosfechamento->delete($processo);
                break;
        }
    }

    public function itensProcesso($op, $idProcesso, $id) {
        $this->set("op", $op);
        $this->set("processo", $idProcesso);
        $this->set("ncm", $id);
        $this->set("tipoProcesso", $this->importacoes_processos->first(array("conditions" => array("processo" => $processo), "fields" => "tipoProcesso")));
        switch ($op) {
            default:
            case "grid":
                $condicao = array(
                    "conditions" => array(
                        "processo" => $idProcesso
                    ),
                    "fields" => array("id", "produto_id", "ncm", "peso", "qtd", "preco", "precoExterior", "processo"),
                    "order" => "ncm ASC"
                );
                $this->set("dadosGrid", $this->importacoes_produtos->all($condicao));
                break;
            case "gridOrcamento":
                $condicao = array(
                    "conditions" => array(
                        "processo" => $idProcesso
                    ),
                    "fields" => array("id", "produto_id", "ncm", "peso", "qtd", "preco", "precoExterior", "processo"),
                    "order" => "ncm ASC"
                );
                $this->set("dadosGrid", $this->importacoes_produtos->all($condicao));
                break;
            case "gridAdicoes":
                $condicaoAdicao = array(
                    "groupBy" => "ncm",
                    "conditions" => array(
                        "processo" => $idProcesso
                    ),
                    "fields" => array(
                        "format(sum(ii),2) as ii",
                        "format(sum(ipiEntrada),2) as ipi",
                        "format((sum(pis)+sum(cofins)),2) as pisCofins",
                        "format(sum(icmsEntrada),2) as icmsEntrada",
                        "format(sum(peso),3) as peso",
                        "format(sum(frete),2) as frete",
                        "format(sum(seguro),2) as seguro",
                        "format(sum(thc),2) as thc",
                        "format(sum(taxaSiscomex),2) as taxaSiscomex",
                        "ncm",
                        "processo"
                    )
                );
                $this->set("dadosForm", $this->importacoes_produtos->all($condicaoAdicao));

                break;

            case "cadastrar":
                if (!empty($this->data)) {
                    $this->data["id"] = $id;
                    $this->data["processo"] = $idProcesso;
                    $produto = $this->estoque_produtos->firstById($this->data["produto_id"]);
                    $condicaoFornecedor = array(
                        "conditions" => array(
                            "fornecedores_id" => $produto["fornecedor"]["id"],
                            "processo" => $idProcesso
                        )
                    );
                    if ($this->importacoes_fabricantesprocesso->count($condicaoFornecedor) == 0) {
                        $dado["processo"] = $idProcesso;
                        $dado["fornecedores_id"] = $produto["fornecedor"]["id"];
                        $this->importacoes_fabricantesprocesso->save($dado);
                    }
                    $this->data = array_merge($this->data, $this->ImportacoesComponent->getAliquotasIcms($idProcesso));
                    $this->data["peso"] = $this->data["peso"] * $this->data["qtd"];
                    $this->importacoes_produtos->save($this->data);
                }
                $this->set("dadosForm", $this->importacoes_produtos->firstById($id));
                break;
            case "deletar":
                $this->importacoes_produtos->delete($idProcesso);
                break;

            case "impostosAdicao":
                if (!empty($this->data)) {
                    $this->set("dadosEnviados", $this->data);
                }
                $condicao = array(
                    "conditions" => array(
                        "processo" => $idProcesso,
                        "ncm" => $id
                    ),
                    "groupBy" => "ncm"
                    ,
                    "fields" => array(
                        "*",
                        "sum(peso) as pesoAdicao",
                        "format(sum(antiDumping),3) as antiDumpingTotal"
                    )
                );
                $this->set("dadosForm", $this->importacoes_produtos->first($condicao));
                break;
        }
    }

    public function recalculaProcesso($processo) {
        $this->set("processo", $processo);
    }

    public function geraNotaEntrada($processo, $tpNfe) {

        ini_set("display_errors", "1");
        $ide = array(
            "tpNFe" => $tpNfe
        );
        $this->NfeComponent->startFromProcesso("importacao", $processo);
        ini_set("display_errors", "0");
    }

    public function dashboard($op, $id) {
        $this->set("op", $op);

        switch ($op) {
            case "grid":

                $condicao = array(
                    "conditions" => array(
                        "dashboard" => "1"
                    ),
                    "fields" => array(
                        "id", "nome"
                    )
                );
                $this->set("dadosGrid", $this->importacoes_status->all($condicao));
                break;
            case "processos":
                $condicao = array(
                    "conditions" => array(
                        "status_id" => $id
                    ),
                    "fields" => array(
                        "id", "processo", "created", "cliente_id", "modified", "who"
                    )
                );
                $this->set("dadosGrid", $this->importacoes_processos->all($condicao));
                break;
            default:
            case "index":
                $this->set("processos", $this->importacoes_processos->dashBoard());
                break;
        }
    }

    public function agentesCarga($op, $id) {
        $this->set("op", $op);

        switch ($op) {
            case "cadastrar":
                if (!empty($this->data)) {
                    $this->data["id"] = $id;
                    if (!$this->importacoes_agentescarga->save($this->data)) {
                        die("Ocorreu algum erro durante sua requisição, tente novamente.");
                    } else {
                        die("Salvo com Sucesso");
                    }
                }
                $this->set("dadosForm", $this->importacoes_agentescarga->firstById($id));
                break;
            case "deletar":
                if ($this->importacoes_agentescarga->delete($id)) {
                    die("OK");
                } else {
                    die("FAIL");
                }
                break;

            default:
            case "grid":
                $condicao = array(
                    "fields" => array(
                        "id",
                        "razaoSocial",
                        "tel",
                        "fax"
                    ),
                    "order" => "nomeFantasia, razaoSocial",
                    "limit" => "15"
                );
                $this->set("dadosGrid", $this->importacoes_agentescarga->all($condicao));
                break;
        }
    }

    public function index($op, $subop) {
        $this->set("op", $op);
        switch ($op) {
            case "scheudule":
                $this->ImportacoesComponent->scheudule();
                die();
                break;

            default:

                break;
        }
    }

    public function configModulo() {
        $IDConfig = 500;
        if (!empty($this->data)) {
            $this->data["modulo"] = $this->moduloID;
            $this->data["config"] = $IDConfig;
            //$this->data["id"] = $this->admin_config->getId($this->moduloID, $IDConfAlertaAtracacao);
            if ($this->admin_config->save($this->data)) {
                die("Salvo com Sucesso");
            } else {
                die("Ocorreu um Erro, veirfique com o Administrador do Sistema");
            }
        }
        $this->set("dadosForm", $this->admin_config->firstById($this->admin_config->getId($this->moduloID, $IDConfig)));

        $this->set("layoutEmailAtracacao", $this->marketing_templateemails->listaModulo($this->moduloID));
    }

}

?>
