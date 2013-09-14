<?php

class ImportacoesHelper extends Helper {

    //Numero do Processo caso precise ser usada por alguma função iniciadora;
    private $idProcesso;
    //Numero do NCM para limitar a criação dos produtos;
    private $idNcm = null;
    //Dados do processo
    public $processo = array();
    //Todos os produtos da importação
    public $produtos = array();
    //Mantem dados das adições salvas na classe
    public $adicoes = array();

    public function calcAll($processo = null) {
        if ($processo != null) {
            $this->idProcesso = $processo;
            $this->setProcesso();

            $this->setProdutos();

            $this->setPesoTotal();

            $this->calcFob();
            $this->calcSeguroMaritimo();
            $this->calcCif();
            $this->updateDespesas();
            $this->rateio();


            $i = 0;
            while ($i < count($this->produtos)) {
                $this->getCif($i);
                $this->calculaII($i);
                $this->calculaIPI($i);
                $this->calculaPis($i);
                $this->calculaCofins($i);

                if ($this->produtos[$i]["cst"] == "100" || $this->produtos[$i]["cst"] == "110" || $this->produtos[$i]["cst"] == "120" || $this->produtos[$i]["cst"] == "170") {
                    $this->calculaICMS($i);
                    $this->produtos[$i]["icmsSt"] = 0;
                } elseif ($this->produtos[$i]["cst"] == "140" || $this->produtos[$i]["cst"] == "141") {
                    $this->produtos[$i]["icmsEntrada"] = "0";
                    $this->produtos[$i]["icmsSaida"] = "0";
                }
                $this->calculaIPISaida($i);
                if ($this->produtos[$i]["cst"] == "110" || $this->produtos[$i]["cst"] == "130") {
                    $this->calculaIcmsSt($i);
                }
                $this->calcAntidumping($i);

                $i++;
            }
            $retorno["tipoProcesso"] = $this->processo["tipoProcesso"];
            if ($this->salvaProdutos()) {
                $retorno["save"] = true;
            } else {
                $retorno["save"] = false;
            }
            
        }
        return $retorno;
    }

    public function calculate($mathString) {
        $mathString = trim($mathString);     // trim white spaces
        $mathString = ereg_replace('[^0-9\+-\*\/\(\) ]', '', $mathString);    // remove any non-numbers chars; exception for math operators

        $compute = create_function("", "return (" . $mathString . ");");
        return 0 + $compute();
    }

    public function calcFob() {
        if (!empty($this->idNcm)) {
            $this->processo["fob"] = $this->fob($this->idProcesso, $this->idNcm, null, "adicao") * $this->processo["txCambio"];
        } else {
            $this->processo["fob"] = $this->fob($this->idProcesso) * $this->processo["txCambio"];
        }
        return $this->processo["fob"];
    }

    public function calcSeguroMaritimo() {
        if ($this->processo["seguro"] == "0.00") {
            $this->processo["seguro"] = $this->processo["fob"] * 0.005;
        }
    }

    public function calcCif() {
        $this->processo["cif"] = $this->processo["fob"] + $this->processo["frete"] + ($this->processo["thc"]) + $this->processo["seguro"];
        return $this->processo["cif"];
    }

    public function setPesoTotal() {
        foreach ($this->produtos as $produto) {
            $this->processo["pesoTotal"] = $this->processo["pesoTotal"] + ($produto["peso"] * $produto["qtd"]);
        }
    }

    public function updateDespesas() {

        $importacoes_nacionalizacao = ClassRegistry::load("importacoes_nacionalizacao", "Model");

        $custosTerminal = $importacoes_nacionalizacao->allWithFormula($this->idProcesso);

        $avaibleVars = array(
            "{cif}" => $this->processo["cif"],
            "{fob}" => $this->processo["fob"],
            "{freteInternacional}" => $this->processo["frete"],
            "{qtdContainer}" => $this->processo["qtdContainer"],
            "{qtdCarretas}" => $this->processo["qtdCarretas"]
        );
        $multiplicacao = array(
            "0" => "1", //Não multiplica
            "1" => $this->processo["qtdContainer"], //container
            "2" => $this->processo["qtdCarretas"] //Carretas
        );

        foreach ($custosTerminal as $custo) {
            $save[] = array(
                "id" => $custo["id"],
                "valorTotal" => $valorTotal = (!empty($custo["valorTerminal"])) ? (!empty($custo["formula"])) ? $this->calculate(strtr($custo["formula"], $avaibleVars)) * $multiplicacao[$custo["multiplicacao"]] : $custo["valorTerminal"] * $multiplicacao[$custo["multiplicacao"]]  : $custo["valorUnitario"] * $multiplicacao[$custo["multiplicacao"]],
                "valorUnitario" => $valorTotal / $multiplicacao[$custo["multiplicacao"]]
            );
        }
        $importacoes_nacionalizacao->saveAll($save);
    }

    public function rateio() {
        $i = 0;
        while ($i < count($this->produtos)) {
            $this->produtos[$i]["fob"] = (($this->produtos[$i]["precoExterior"] * $this->produtos[$i]["qtd"]) * $this->processo["txCambio"]);

            $fatorFob = $this->produtos[$i]["fob"] / $this->processo["fob"];
            $fatorPeso = ($this->produtos[$i]["peso"] * $this->produtos[$i]["qtd"]) / $this->processo["pesoTotal"];

            $this->produtos[$i]["frete"] = $this->processo["frete"] * $fatorPeso;

            $this->produtos[$i]["thc"] = $this->processo["thc"] * $fatorFob;
            $this->produtos[$i]["seguro"] = $this->processo["seguro"] * $fatorFob;

            $this->produtos[$i]["cif"] = ($this->produtos[$i]["fob"] + $this->produtos[$i]["frete"] + $this->produtos[$i]["thc"] + $this->produtos[$i]["seguro"]);

            //$fatorCif = $this->produtos[$i]["cif"] / $this->processo["cif"];

            $this->produtos[$i]["taxaSiscomex"] = $this->processo["taxaSiscomex"] * $fatorFob;

            $this->produtos[$i]["despesasAduaneiras"] = $this->processo["despesasAduaneiras"] * $fatorFob;

            $i++;
        }
    }

    public function getCif($i) {
        $this->produtos[$i]["fob"] = (($this->produtos[$i]["precoExterior"] * $this->produtos[$i]["qtd"]) * $this->processo["txCambio"]);
        $this->produtos[$i]["cif"] = ($this->produtos[$i]["fob"] + $this->produtos[$i]["frete"] + $this->produtos[$i]["thc"] + $this->produtos[$i]["seguro"]);
        return $this->produtos[$i]["cif"];
    }

    public function calculaII($i) {
        $formula = $this->processo["operacao"]["II"];
        $cif = $this->produtos[$i]["cif"];
        $aliqIi = $this->produtos[$i]["aliqIi"] / 100;
        if (!empty($formula) || $formula !=0) {
            eval("\$resultado = " . $formula);
        }
        $this->produtos[$i]["ii"] = $resultado;
    }

    public function calculaIPI($i) {

        $formula = $this->processo["operacao"]["IPIEntrada"];
        $cif = $this->produtos[$i]["cif"];
        $ii = $this->produtos[$i]["ii"];
        $aliqIpi = $this->produtos[$i]["aliqIpi"] / 100;
        if (!empty($formula) || $formula !=0) {
            eval("\$resultado = " . $formula);
        }
        $this->produtos[$i]["ipiEntrada"] = $resultado;
    }

    public function calculaIPISaida($i) {
        $formula = $this->processo["operacao"]["IPISaida"];

        $cif = $this->produtos[$i]["cif"];
        $ii = $this->produtos[$i]["ii"];
        $pis = $this->produtos[$i]["pis"];
        $cofins = $this->produtos[$i]["cofins"];
        $icmsSaida = $this->produtos[$i]["icmsSaida"];
        $despesasAduaneiras = $this->produtos[$i]["despesasAduaneiras"];
        $taxaSiscomex = $this->produtos[$i]["taxaSiscomex"];

        $aliqIpi = $this->produtos[$i]["aliqIpi"] / 100;
        if (!empty($formula) || $formula !=0) {
            eval($formula);
        }
        $this->produtos[$i]["ipiSaida"] = $ipiSaida;
        $this->produtos[$i]["produtoItem"] = $totalProduto;
    }

    public function calculaPis($i) {
        $formula = $this->processo["operacao"]["PIS"];
        $aliqPis = $this->produtos[$i]["aliqPis"] / 100;

        $xis = $this->calcX($i);
        $cif = $this->produtos[$i]["cif"];
        if (!empty($formula) || $formula !=0) {
            eval("\$resultado = " . $formula);
        }
        $this->produtos[$i]["pis"] = $resultado;
    }

    public function calculaCofins($i) {
        $formula = $this->processo["operacao"]["COFINS"];
        $aliqCofins = $this->produtos[$i]["aliqCofins"] / 100;
        $xis = $this->calcX($i);
        $cif = $this->produtos[$i]["cif"];
        if (!empty($formula) || $formula !=0) {
            eval("\$resultado = " . $formula);
        }
        $this->produtos[$i]["cofins"] = $resultado;
    }

    public function calcX($i) {
        $icms = $this->produtos[$i]["aliqIcmsInternaPisCofins"] / 100;
        $ii = $this->produtos[$i]["aliqIi"] / 100;
        $ipi = $this->produtos[$i]["aliqIpi"] / 100;
        $pis = $this->produtos[$i]["aliqPis"] / 100;
        $cofins = $this->produtos[$i]["aliqCofins"] / 100;

        return (1 + $icms * ($ii + $ipi * (1 + $ii))) / ((1 - $pis - $cofins) * (1 - $icms));
    }

    public function calculaICMS($i) {

        $formula = $this->processo["operacao"]["ICMSEntrada"];
        $aliqIcmsInterna = $this->produtos[$i]["aliqIcmsInterna"] / 100;
        $aliqIcmsInterestadual = $this->produtos[$i]["aliqIcmsInterestadual"] / 100;
        $pis = $this->produtos[$i]["pis"];
        $cofins = $this->produtos[$i]["cofins"];

        $despesasAduaneiras = $this->produtos[$i]["despesasAduaneiras"];
        $antiDumping = $this->produtos[$i]["antiDumping"];

        $taxaSiscomex = $this->produtos[$i]["taxaSiscomex"];
        $ii = $this->produtos[$i]["ii"];
        $ipi = $this->produtos[$i]["ipiEntrada"];
        $cif = $this->produtos[$i]["cif"];

        $complementoInterno = $this->calcComplemento($aliqIcmsInterna);
        $complementoInterestadual = $this->calcComplemento($aliqIcmsInterestadual);
        if (!empty($formula) || $formula !=0) {
            eval($formula);
        }
        $this->produtos[$i]["baseIcmsEntrada"] = $baseIcmsEntrada;
        $this->produtos[$i]["icmsEntrada"] = $icmsEntrada;

        //Faz os calculos do ICMS da NF de saída
        $formula = $this->processo["operacao"]["ICMSSaida"];

        switch ($this->processo["destinacao"]) {
            default:
            case "1":
                $aliqIcms = $this->produtos[$i]["aliqIcmsInterestadual"] / 100;
                $complemento = $this->calcComplemento($aliqIcmsInterna);
                break;
            case "2":
                $aliqIcms = $this->produtos[$i]["aliqIcmsInterestadual"] / 100;
                $complemento = $this->calcComplemento($aliqIcms);
                break;
            case "3":
                $aliqIcms = $this->produtos[$i]["aliqIcmsInterna"];
                $aliqIcms = $aliqIcms * (1 + ($this->produtos[$i]["aliqIpi"] / 100));
                $complemento = $this->calcComplemento($aliqIcms);
                break;
        }


//        if ($this->processo["lucroReal"] == 0) {
//            $pis = 0;
//            $cofins = 0;
//        }
//        if ($this->processo["industrial"] == 0) {
//            $ipi = 0;
//        }

        if ($this->processo["enquadramento"] == 1) {
            $aliqIcms = $this->produtos[$i]["aliqIcmsInterestadual"];
            $complemento = $this->calcComplemento($aliqIcmsInterna);
        }


        if (!empty($formula) || $formula !=0) {
            eval($formula);
        }
        $this->produtos[$i]["baseIcmsSaida"] = $baseIcmsSaida;
        $this->produtos[$i]["icmsSaida"] = $icmsSaida;
    }

    public function calculaIcmsSt($i) {
        $authComponent = ClassRegistry::load("AuthComponent", "Component");
        $estadoEmissor = $authComponent->user();


        if ($this->processo["cliente"]["estado"] != $estadoEmissor["empresa"]["estado"]) {
            
        } else {
            $aliqIcmsSt = 0;
        }


        $formula = $this->processo["operacao"]["ICMSST"];
        $totalProduto = $this->produtos[$i]["produtoItem"];
        $ipiSaida = $this->produtos[$i]["ipiSaida"];
        $aliqIcmsInterna = $this->produtos[$i]["aliqIcmsInterna"] / 100;
        $aliqIcmsSt = $this->produtos[$i]["aliqIcmsSt"] / 100;
        $icmsSaida = $this->produtos[$i]["icmsSaida"];
        if (!empty($formula) || $formula !=0) {
            eval($formula);
        }
        if ($icmsSt < 0) {
            $baseIcmsSt = 0;
            $icmsSt = 0;
        }
        $this->produtos[$i]["baseIcmsSt"] = $baseIcmsSt;
        $this->produtos[$i]["icmsSt"] = $icmsSt;
    }

    public function calcAntidumping($i) {
        if ($this->produtos[$i]["tipoAntidumping"] == 1) {
            //Calcula % cif;
            $this->produtos[$i]["antiDumping"] = $this->getCif($i) * ($this->produtos[$i]["aliqAntiDumping"] / 100);
        } elseif ($this->produtos[$i]["tipoAntidumping"] == 2) {
            //Calcula valor absoluto por tonelada/unidade
            $this->produtos[$i]["antiDumping"] = $this->produtos[$i]["aliqAntiDumping"] * $this->produtos[$i]["qtd"];
        } elseif ($this->produtos[$i]["tipoAntidumping"] == 3) {
            //Valor determinado e já reateado não faz nada
        } else {
            //Zera o valor do Antidumping
            $this->produtos[$i]["antiDumping"] = "0";
        }
    }

    public function calcComplemento($aliquota) {
        return (1 - $aliquota);
    }

    public function setProcesso() {
        $modelProcessos = ClassRegistry::load("importacoes_processos", "Model");

        $this->processo = $modelProcessos->first(array("conditions" => array("processo" => $this->idProcesso)));

        $modelNacionalizacao = ClassRegistry::load("importacoes_nacionalizacao", "Model");
        $condicao = array(
            "conditions" => array(
                "processo" => $this->idProcesso
            ),
            "fields" => array("sum(valorTotal) as soma")
        );
        $result = $modelNacionalizacao->first($condicao);
        $this->processo["despesasAduaneiras"] = $result["soma"];
    }

    public function setProdutos() {
        $model = ClassRegistry::load("importacoes_produtos", "Model");
        $condicao = array(
            "conditions" => array(
                "processo" => $this->idProcesso
            )
        );
        if (!empty($this->idNcm)) {
            $condicao["conditions"]["ncm"] = $this->idNcm;
        }
        $this->produtos = $model->all($condicao);
    }

    public function salvaProdutos() {
        $model = ClassRegistry::load("importacoes_produtos", "Model");
        return $model->saveAll($this->produtos);
    }

    public function formatMoeda($valor = 0, $prefix = "R$") {
        if (!$prefix) {
            return number_format($valor, 2, ',', '.');
        } else {
            return $prefix . " " . number_format($valor, 2, ',', '.');
        }
    }

    public function overView($processo) {
        //Montar array com dados principais do processo
    }

    public function countAdicoes($processo = null) {
        $model = ClassRegistry::load("importacoes_produtos", "Model");

        $condicao = array(
            "fields" => array(
                "*"
            ),
            "conditions" => array(
                "processo" => $processo
            ),
            "groupBy" => "ncm"
        );
        return count($model->all($condicao));
    }

    public function fob($processo = null, $adicao = null, $item = null, $metodo = "processo", $formatado = false, $cambio = false) {
        $model = ClassRegistry::load("importacoes_produtos", "Model");

        switch ($metodo) {
            case "item":
                $fob = $model->firstById($item);
                $fob = $fob["precoExterior"] * $fob["qtd"];
                break;
            case "adicao":
                $condicao = array(
                    "conditions" => array(
                        "ncm" => $adicao,
                        "processo" => $processo
                    )
                );
                $itens = $model->all($condicao);
                foreach ($itens as $item) {
                    $fob = $fob + ($item["precoExterior"] * $item["qtd"]);
                }
                break;
            case "processo":
                $condicao = array(
                    "conditions" => array(
                        "processo" => $processo
                    )
                );
                $itens = $model->all($condicao);
                foreach ($itens as $item) {
                    $fob = $fob + ($item["precoExterior"] * $item["qtd"]);
                }
                break;
        }

        if ($cambio) {
            $fob = $this->cambio($processo, $fob);
        }

        if ($formatado && $cambio) {
            $fob = $this->formatMoeda($fob, "R$");
        } elseif ($formatado && !$cambio) {
            $fob = $this->formatMoeda($fob, $item["estoque_produtos"]["moeda"]["simbolo"]);
        }

        return $fob;
    }

    public function cambio($processo, $fob) {
        $model = ClassRegistry::load("importacoes_processos", "Model");

        $condicao = array(
            "conditions" => array(
                "processo" => $processo
            ),
            "fields" => array(
                "txCambio"
            )
        );
        $processo = $model->first($condicao);

        return $fob * $processo["txCambio"];
    }

    public function sumProcesso($processo, $campo) {
        $model = ClassRegistry::load("importacoes_produtos", "Model");

        $condicao = array(
            "conditions" => array(
                "processo" => $processo
            ),
            "fields" => array("$campo as soma")
        );
        $soma = $model->first($condicao);
        return $soma["soma"];
    }

    public function sumAdicao($processo, $ncm, $campo) {
        $model = ClassRegistry::load("importacoes_produtos", "Model");

        $condicao = array(
            "conditions" => array(
                "processo" => $processo,
                "ncm" => $ncm
            ),
            "fields" => array("$campo as soma")
        );
        $soma = $model->first($condicao);
        return $soma["soma"];
    }

    public function getAliquotas($ncm) {
        $model = ClassRegistry::load("sys_ncm", "Model");

        $condicao = array(
            "conditions" => array(
                "ncm" => $ncm
            )
        );
        return $model->first($condicao);
    }

    public function getItensAdicao($processo, $ncm) {
        $model = ClassRegistry::load("importacoes_produtos", "Model");
        $condicao = array(
            "conditions" => array(
                "processo" => $processo,
                "ncm" => $ncm
            )
        );

        return $model->all($condicao);
    }

    public function getItensMemorial($processo, $ncm) {
        $model = ClassRegistry::load("importacoes_produtos", "Model");
        $condicao = array(
            "conditions" => array(
                "processo" => $processo,
                "ncm" => $ncm
            )
        );

        return $model->all($condicao);
    }

    public function slice($length, $complement, $text) {
        if (strlen($text) > $length):
            $text = substr($text, 0, $length);
            $length = strrpos($text, " ");

            return substr($text, 0, $length) . $complement;
        else:
            return $text;
        endif;
    }

    //funções que podem ser acessadas diretamente.
    public function updateAdicao($dados, $processo, $ncm) {
        $this->idProcesso = $processo;
        $this->idNcm = $ncm;

        $this->setProcesso();

        $this->setProdutos();

        $this->setPesoTotal();

        $this->calcFob();
        //$this->calcCif();
        $i = 0;
        while ($i < count($this->produtos)) {
            $this->produtos[$i]["fob"] = (($this->produtos[$i]["precoExterior"] * $this->produtos[$i]["qtd"]) * $this->processo["txCambio"]);
            $fatorFob = $this->produtos[$i]["fob"] / $this->processo["fob"];
            $this->produtos[$i]["peso"] = $dados["pesoAdicao"] * $fatorFob;
            $this->produtos[$i]["antiDumping"] = $dados["antiDumpingTotal"] * $fatorFob;

            $this->produtos[$i]["aliqIi"] = $dados["aliqIi"];
            $this->produtos[$i]["aliqIpi"] = $dados["aliqIpi"];
            $this->produtos[$i]["aliqPis"] = $dados["aliqPis"];
            $this->produtos[$i]["aliqCofins"] = $dados["aliqCofins"];
            $this->produtos[$i]["aliqIcmsInterestadual"] = $dados["aliqIcmsInterestadual"];
            $this->produtos[$i]["aliqIcmsInternaPisCofins"] = $dados["aliqIcmsInternaPisCofins"];
            $this->produtos[$i]["aliqIcmsInterna"] = $dados["aliqIcmsInterna"];
            $this->produtos[$i]["aliqIcmsSt"] = $dados["aliqIcmsSt"];
            $i++;
        }
        $this->salvaProdutos();
    }

    //Funções que não modificarão com a reestruturação do HELPER

    public function getStatus($processo) {
        
    }

}

?>
