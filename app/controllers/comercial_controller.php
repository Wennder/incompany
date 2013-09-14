<?php

class comercialController extends AppController {

    public $moduloId = 2;
    public $uses = array(
        "comercial_clientes",
        "comercial_tipo_contrato",
        "comercial_contratos",
        "comercial_contatos",
        "comercial_anexos",
        "comercial_aditamento",
        "comercial_representantes",
        "comercial_clientesenderecos",
        "comercial_clientesconsumo",
        "comercial_clienteshistoricocontato",
        "comercial_comportamentomercado",
        "estoque_catprodutos",
        "sys_empresas",
        "rh_funcionarios"
    );

    public function clientes($op, $id = null) {
        $this->set("op", $op);
        $this->set("id", $id);
        
        switch ($op) {
            case "buscar":
                $condicao = array(
                    "conditions" => array(
                        "pai" => "0"
                    ),
                    "displayField" => "nome",
                    "order" => "nome"
                );
                $this->set("dadosCat1", $this->estoque_catprodutos->toList($condicao));
                break;
            case "primeiroContato":
                if (!empty($this->data)) {
                    $this->data["razaoSocial"] = $this->data["nomeFantasia"];
                    $this->comercial_clientes->save($this->data);
                    $IdCliente = $this->comercial_clientes->getInsertId();
                    $dadosContato = array(
                        "email" => $this->data["contato_email"],
                        "nome" => $this->data["contato_nome"],
                        "tel1" => $this->data["contato_tel1"],
                        "tel2" => $this->data["contato_tel2"],
                        "id_cliente" => $IdCliente
                    );
                    $this->comercial_contatos->save($dadosContato);
                    $this->redirect("/comercial/clientes/enviaEmailPrimeiroContato/$IdCliente");
                }
                break;
            case "enviaEmailPrimeiroContato":
                if (!empty($this->data)) {
                    if (is_numeric($this->data["template"])) {
                        $template = $this->data["template"];
                    } else {
                        $template = array(
                            "assunto" => $this->data["assunto"],
                            "mensagem" => $this->data["mensagem"]
                        );
                    }
                    $this->EmailComponent->newEmail($this->moduloId, null, $template, $id)
                            ->authSend();
                }
                break;
            case "cadastrar":
                if (!empty($this->data)) {
                    if ($this->data["tipoCliente"] == "pf") {
                        $this->data["razaoSocial"] = $this->data["razaoSolcialPf"];
                        $this->data["cnpj"] = $this->data["cnpjPf"];
                        $this->data["ie"] = $this->data["iePf"];
                        $this->data["orgaoEmissor"] = $this->data["orgaoEmissorPf"];
                        $this->data["estadoEmissor"] = $this->data["estadoEmissorPf"];
                    }
                    if (!empty($id)) {
                        $this->data['id'] = $id;
                    }
                    if (!$this->comercial_clientes->save($this->data)) {
                        $this->setAlert("Não foi possivel realizar sua requisição, tente novamente!");
                    } else {
                        $idSalvo = $this->comercial_clientes->getInsertId();

                        //Redireciona depois de salvar
                        $this->redirect("/comercial/clientes/cadastrar/" . (!empty($idSalvo) ? $idSalvo : $id));
                    }
                }
                $this->set("dados", $this->comercial_clientes->firstById($id));
                $this->set("optRepresentantes", $this->comercial_representantes->toList(array("displayField" => "nomeFantasia", "orderBy" => "nomeFantasia")));
                break;
            case"deletar":
                $this->comercial_clientes->delete($id, true);
                break;

            case "grid":
                $this->set("dadosGrid", $this->comercial_clientes->findForm($this->data));
                break;

            case "printFichaCliente":
                $where = array(
                    "conditions" => array(
                        "id" => $id
                    )
                );
                $this->set("dados", $this->comercial_clientes->first($where));
                break;
        }
    }

    public function clientesEnderecos($op = "grid", $idCliente = null, $id = null) {
        $this->set("op", $op);
        $this->set("idCliente", $idCliente);
        $this->set("id", $id);
        switch ($op) {
            default:
            case "grid":
                $condicao = array(
                    "conditions" => array(
                        "cliente_id" => $idCliente
                    ),
                    "order" => "tipoEndereco"
                );

                $this->set("dadosGrid", $this->comercial_clientesenderecos->all($condicao));

                break;
            case "cadastrar":
                if (!empty($this->data)) {
                    $this->data["id"] = $id;
                    $this->data["cliente_id"] = $idCliente;
                    if ($this->comercial_clientesenderecos->save($this->data)) {
                        die("Salvo com Sucesso.");
                    } else {
                        die("Houve um erro ao Salvar o Registro, Tente novamente");
                    }
                }
                $this->set("dadosForm", $this->comercial_clientesenderecos->firstById($id));
                break;
            case "deletar":
                $this->comercial_clientesenderecos->delete($id);

                break;
        }
    }

    public function clientesConsumo($op = "grid", $idCliente = null, $id = null) {
        $this->set("op", $op);
        $this->set("cliente_id", $idCliente);

        switch ($op) {
            case "cadastrar":
                if (!empty($this->data)) {
                    $this->data["id"] = $id;
                    $this->data["cliente_id"] = $idCliente;
                    $this->comercial_clientesconsumo->save($this->data);
                }
                $this->set("dadosForm", $this->comercial_clientesconsumo->firstById($id));
                break;
            case "deletar":
                //Quando for deletar, ID do registro é passado por idCliente.
                $this->comercial_clientesconsumo->delete($idCliente);
                break;
            default:
            case "grid":
                $condicao = array(
                    "conditions" => array(
                        "cliente_id" => $idCliente
                    )
                );

                $this->set("dadosGrid", $this->comercial_clientesconsumo->all($condicao));
                break;
        }
    }

    public function clientesHistorico($op, $idCliente = null, $id = null) {
        $this->set("op", $op);
        $this->set("cliente_id", $idCliente);
        switch ($op) {
            case "cadastrar":
                if (!empty($this->data) && !empty($idCliente) && empty($id)) {
                    $this->data["id"] = $id;
                    $this->data["cliente_id"] = $idCliente;
                    $this->data["remind"] = $this->FormComponent->dataMysql($this->data["remind"]);
                    $this->comercial_clienteshistoricocontato->save($this->data);
                }
                $this->set("dadosForm", $this->comercial_clienteshistoricocontato->firstById($id));
                break;
            case "grid":
                $condicao = array(
                    "conditions" => array(
                        "cliente_id" => $idCliente
                    )
                );
                $this->set("dadosGrid", $this->comercial_clienteshistoricocontato->all($condicao));
                break;
        }
    }

    public function cadTipoContrato($op = "grid", $id = null) {
        $this->set("op", $op);
        switch ($op) {
            case "novo":
                if (!empty($this->data)) {
                    $this->data["id"] = $id;
                    if ($this->comercial_tipo_contrato->save($this->data)) {
                        $this->setAlert("Registro salvo com sucesso!");
                        if ($this->comercial_tipo_contrato->getInsertId() == 0) {
                            $idR = $id;
                        } else {
                            $idR = $this->comercial_tipo_contrato->getInsertId();
                        }
                        $this->redirect("/comercial/cadTipoContrato/novo/$idR");
                    } else {
                        $this->setAlert("Não foi possivel fazer esse registro, tente novamente!");
                    }
                }

                $conditionDados = array(
                    "conditions" => array(
                        "id" => $id
                    )
                );
                $this->set("dadosTipoContrato", $this->comercial_tipo_contrato->first($conditionDados));
                break;
            case "grid":
                $where = array(
                    "order" => "nome ASC",
                    "fields" => array(
                        "id",
                        "nome",
                        "created",
                        "modified"
                    )
                );
                $this->set("gridTipoContrato", $this->comercial_tipo_contrato->all($where));
                break;

            case "deletar":
                $this->comercial_tipo_contrato->delete($id);
                $this->redirect("/comercial/cadTipoContrato/");
                break;
        }
    }

    public function contratos($op, $id = null) {
        $this->set("op", $op);
        switch ($op) {
            case "novo":
                $this->set("comboClientes", $this->comercial_clientes->toList(array("displayField" => "razaoSocial", "order" => "razaoSocial ASC")));
                $this->set("comboPrestadoras", $this->sys_empresas->toList(array("conditions" => array("grupoEmpresa_id" => $this->AuthComponent->user("grupoEmpresa_id")), "displayField" => "nomeFantasia", "order" => "nomeFantasia ASC")));
                $this->set("comboTipoContratos", $this->comercial_tipo_contrato->toList(array("displayField" => "nome", "order" => "nome ASC")));
                $this->set("comboGerentes", $this->rh_funcionarios->toList(array(
                            "conditions" => array(
                                "rh_setor_id" => '5'
                            ),
                            "displayField" => "nome",
                            "order" => "nome ASC"
                                )
                        )
                );

                if (!empty($this->data)) {
                    if (!empty($this->data["inicio"]) && $this->data["inicio"] != "00-00-0000") {
                        $inicio = strtotime($this->data["inicio"]);
                        $this->data["inicio"] = date("Y-m-d", $inicio);
                    }

                    if (!empty($this->data["vencimento"]) && $this->data["vencimento"] != "00-00-0000") {
                        $vencimento = strtotime($this->data["vencimento"]);
                        $this->data["vencimento"] = date("Y-m-d", $vencimento);
                    }
                    if ($id == null) {
                        $id = $this->comercial_contratos->getInsertId();
                    }
                    $this->data['id'] = $id;

                    if ($this->comercial_contratos->save($this->data)) {
                        if ($id == 0) {
                            $id = $this->comercial_contratos->getInsertId();
                        }
                        $this->setAlert("Registro salvo com sucesso!");
                        if ($this->data["acao"] == 0) {
                            $this->redirect("/comercial/contratos/novo/" . $id);
                        } else {
                            $this->redirect("/comercial/contratos/print/" . $id);
                        }
                    } else {
                        $this->setAlert("Houve um erro em sua solicitação, tente novamente!");
                    }
                }

                $conditionDados = array(
                    "conditions" => array(
                        "id" => $id
                    )
                );
                $this->set("dadosContratos", $this->comercial_contratos->first($conditionDados));


                break;
            case "grid":
                $conditionGrid = array(
                    "conditions" => array(
                        "id_cliente" => $this->AuthComponent->user("id")
                    ),
                    "fields" => array(
                        "id",
                        "id_cliente",
                        "id_gerente",
                        "id_tipo",
                        "valor",
                        "descricao",
                        "status",
                        "vencimento"
                    ),
                    "order" => "id_cliente ASC"
                );
                if (!empty($this->data["data"])) {
                    $conditionGrid["conditions"] = array(
                        $this->data["field"] => $this->data["data"]
                    );
                }

                $this->set("gridContrato", $this->comercial_contratos->all($conditionGrid));
                break;
            case "deletar":
                $this->comercial_contratos->delete($id);
                $this->redirect("/comercial/contratos/grid");

                break;
            case "dashboard":

                break;
            case "avencer":

                break;
            case "buscar":
                $this->layout = false;
                break;
            case "print":
                $this->layout = false;
                break;
        }
    }

    public function clientesContatos($op = "grid", $idCliente = null, $id = null) {
        $this->layout = false;
        $this->set("op", $op);
        switch ($op) {
            case "cadastrar":
                if (!empty($this->data)) {
                    $this->data["id_cliente"] = $idCliente;
                    if (!empty($id)) {
                        $this->data["id"] = $id;
                    }
                    $this->comercial_contatos->save($this->data);
                }
                $this->set("dados", $this->comercial_contatos->firstById($id));
                $this->set("idCliente", $idCliente);
                break;

            case "grid":

                $conditionGrid = array(
                    "conditions" => array(
                        "id_cliente" => $idCliente
                    ),
                    "order" => "id_cliente ASC",
                );
                $this->set("gridContatos", $this->comercial_contatos->all($conditionGrid));
                break;
            case "deletar":
                $this->comercial_contatos->delete($id);
                break;

            case "ver":
                $conditions = array(
                    "conditions" => array(
                        "id_cliente" => $idCliente,
                        "id" => $id
                    )
                );
                $this->set("dados", $this->comercial_contatos->first($conditions));
                break;
        }
    }

    public function dashBoard() {

        $whereAtivo = array(
            "conditions" => array(
                "id_gerente" => $this->AuthComponent->user('id'),
                "status" => "1"
            )
        );

        $this->set("ativos", $this->comercial_contratos->all($whereAtivo));

        $whereInativo = array(
            "conditions" => array(
                "id_gerente" => $this->AuthComponent->user('id'),
                "or" => array(
                    "status" => "2",
                    "vencimento <" => date("Y-m-d")
                )
            )
        );

        $this->set("inativos", $this->comercial_contratos->all($whereInativo));

        $whereAvencer = array(
            "conditions" => array(
                "id_gerente" => $this->AuthComponent->user('id'),
                "vencimento <=" => date("Y-m-d")
            )
        );

        $this->set("aVencer", $this->comercial_contratos->all($whereAvencer));

        $whereClienteContrato = array(
            "conditions" => array(
                "id_gerente" => $this->AuthComponent->user('id')
            ),
            "fields" => array(
                "count(*) as qtd",
                "id_cliente"
            ),
            "groupBy" => "id_cliente",
            "order" => "qtd DESC"
        );

        $this->set("clienteContrato", $this->comercial_contratos->all($whereClienteContrato));
    }

    public function getMinutaTipoContrato($idTipoContrato) {
        $this->layout = false;
        $condicao = array(
            "conditions" => array(
                "id" => $idTipoContrato
            )
        );
        $this->set("dados", $this->comercial_tipo_contrato->first($condicao));
    }

    public function docsContrato($contratoId, $op = "grid", $id = null) {

        $this->layout = false;
        $this->set("op", $op);
        switch ($op) {
            case "novo":
                if (!empty($_FILES)):
                    $this->data['contrato_id'] = $contratoId;
                    $contratoId = $this->data['contrato_id'];
                    $id = $this->data['id'];
                    $nome = $this->data["nome"];
                    $descricao = $this->data["descricao"];
                    $this->UploadComponent->path = "/images/comercial/contratos/$contratoId/";
                    $file = $this->UploadComponent->files["anexo"]; //o erro praticamente estava aqui
                    $filename = $this->AuthComponent->createPassword() . "." . $this->UploadComponent->ext($file);
                    $upload = $this->UploadComponent->upload($file, null, $filename);
                    if ($upload) {
                        unset($this->data);
                        $this->data["anexo"] = $this->UploadComponent->path . $filename;
                        $this->data["contrato_id"] = $contratoId;
                        $this->data["nome"] = $nome;
                        $this->data["descricao"] = $descricao;

                        if (!$this->comercial_anexos->save($this->data)) {
                            $this->setAlert("Houve um problema em sua requisição, tente novamente");
                        }
                    } else {
                        $this->set("erro", $this->UploadComponent->uploadError());
                    }
                endif;
                $this->set("dadosUpload", $this->comercial_anexos->firstById($id));
                break;
            case "grid":
                $conditionGrid = array(
                    "conditions" => array(
                        "contrato_id" => $contratoId
                    ),
                    "order" => "contrato_id ASC",
                );
                $this->set("gridDoc", $this->comercial_anexos->all($conditionGrid));
                break;
            case "deletar":
                $this->comercial_anexos->delete($id);
                break;
        }
    }

    public function aditamentos($contratoId, $op = "grid", $id = null) {
        $this->layout = false;
        $this->set("op", $op);
        switch ($op) {
            case "novo":
                if (!empty($this->data)) {
                    $this->data['id'] = $id;
                    $this->data['contrato_id'] = $contratoId;
                    if (!empty($this->data['inicioVigencia']) && $this->data['inicioVigencia'] != ("00-00-000")) {
                        $inicioVigecia = strtotime($this->data['inicioVigencia']);
                        $this->data['inicioVigencia'] = date("Y-m-d", $inicioVigecia);
                    }
                    if ($this->comercial_aditamento->save($this->data)) {
                        $this->setAlert("Registro incluido com Sucesso!");
                        $this->redirect("/comercial/aditamentos/grid");
                    } else {
                        $this->setAlert("Sua requisição não pode ser concluida, tente novamente!");
                        $this->redirect("/comercial/aditamentos/grid");
                    }
                }
                $this->set("dadosAditamento", $this->comercial_aditamento->firstById($id));
                break;
            case "grid":
                $where = array(
                    "conditions" => array(
                        "contrato_id" => $contratoId
                    ),
                    "order" => "contrato_id ASC"
                );
                $this->set("gridAditamento", $this->comercial_aditamento->all($where));
                break;
            case "deletar":
                $this->comercial_aditamento->delete($id);
                break;
            case "ver":
                //$this->layout= true;
                $this->set("dadosAditamento", $this->comercial_aditamento->firstById($id));
                break;
        }
    }

    public function representantes($op, $id) {
        $this->set("op", $op);

        switch ($op) {
            default:
            case "grid":
                $condicao = array(
                    "fields" => array(
                        "id",
                        "nomeFantasia",
                        "cidade"
                    ),
                    "orderBy" => "nomeFantasia",
                    "limit" => "20"
                );
                $this->set("dadosGrid", $this->comercial_representantes->all($condicao));
                break;
            case "cadastrar":
                if (!empty($this->data)) {
                    $this->data["id"] = $id;
                    if (!$this->comercial_representantes->save($this->data)) {
                        $this->setAlert("Ocorreu algum erro ao processar sua requisição");
                    }
                }
                $this->set("dadosFormulario", $this->comercial_representantes->firstById($id));
                break;
            case "deletar":
                $this->comercial_representantes->delete($id);
                $this->redirect("/comercial/");
                break;
        }
    }

    public function comportamentoMercado($op, $id) {
        $this->set("op", $op);
        switch ($op) {
            default:
            case "grafico":
                $this->set("dadosGrid", $this->comercial_comportamentomercado->dadosPeriodoGrafico($this->data));
                $this->set("dadosGrid2", $this->comercial_comportamentomercado->dadosPeriodoGrid($this->data));
                break;
            case "grid":
                $condicao = array(
                    "conditions" => array(
                        "pai" => "0"
                    ),
                    "displayField" => "nome",
                    "order" => "nome"
                );
                $this->set("dadosCat1", $this->estoque_catprodutos->toList($condicao));
                break;
            case "cadastrar":
                if ((!empty($this->data)) && (!empty($this->data["data"])) && (!empty($this->data["preco"]))) {
                    //Salva os Dados na Tabela de acompamento de mercado
                    $this->data["id"] = $id;
                    $this->data["data"] = $this->FormComponent->dataMysql("00-" . $this->data["data"]);
                    if ($this->comercial_comportamentomercado->save($this->data)) {
                        $sucesso = "Salvo com Sucesso";
                        //Verifica se está habilitado a atualização de valores no consumo
                        if (!empty($this->data["atualizarConsumo"])) {
                            //Ignora comparação de datas para atualização

                            if ($this->comercial_clientesconsumo->updatePrice($this->data)) {
                                $sucesso .= " e Atualizado valores do consumo dos Clientes.";
                            } else {
                                $sucesso .= ", porém ocorreu um erro na ação de atualizar os valores do consumo dos clientes.<br />";
                            }
                        }

                        die($sucesso);
                    } else {
                        die("Ocorreu algum erro na sua requisição, tente novamente.");
                    }
                }
                //Manda os dados pro formulário
                $condicao = array(
                    "conditions" => array(
                        "pai" => "0"
                    ),
                    "displayField" => "nome",
                    "order" => "nome"
                );
                $this->set("dadosCat1", $this->estoque_catprodutos->toList($condicao));
                $this->set("dadosForm", $this->comercial_comportamentomercado->firstById($id));
                break;
            case "deletar":
                if ($this->comercial_comportamentomercado->delete($id)) {
                    die("Deletado com Sucesso");
                } else {
                    die("Ocorreu algum Erro durante a requisição.<br/>Tente novamente.");
                }
                break;
        }
    }

}

?>
