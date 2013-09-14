<?php

require_once("array2xml.php");

class NfeComponent extends Component {

    private $modulo = "";
    private $processo = array();
    private $nfe = array();
    private $optionEstados = array("0" => "Selecione...", "12" => "AC", "27" => "AL", "16" => "AP", "13" => "AM", "29" => "BA", "23" => "CE", "53" => "DF", "32" => "ES", "52" => "GO", "21" => "MA", "51" => "MT", "50" => "MS", "31" => "MG", "15" => "PA", "25" => "PB", "41" => "PR", "26" => "PE", "22" => "PI", "33" => "RJ", "24" => "RN", "43" => "RS", "11" => "RO", "14" => "RR", "42" => "SC", "35" => "SP", "28" => "SE", "17" => "TO", "EX" => "EX");

    public function renderXml() {
        $array2xml = new array2xml();
        return $array2xml->createXML("nfeProc", $this->nfe);
    }

    public function renderArray($nfe) {
        $this->nfe = "";
    }

    public function start($ide, $modulo, $processo) {
        $this->nfe["NFe"]["ide"] = array(
            "cUF" => $ide["cUf"],
            "cNF" => $ide["cNF"],
            "natOpe" => $ide["natOpe"],
            "indPag" => $ide["indPag"],
            "mod" => "55",
            "serie" => $ide["serie"],
            "nNF" => $ide["nNF"],
            "dEmi" => $ide["dEmi"],
            "dSaiEnt" => $ide["dSaiEnt"],
            "hSaiEnt" => $ide["hSaiEnt"],
            "tpNFe" => $ide["tpNFe"],
            "cMunFG" => $ide["cMunFG"],
            "tpImp" => $ide["tpImp"],
            "tpEmis" => $ide["tpEmis"],
            "cDV" => $ide["cDV"],
            "tpAmb" => "1",
            "finNFe" => $ide["finNFe"],
            "procEmi" => "0",
            "verProc" => "Syntex ERP - V3"
        );

        $this->modulo = $modulo;
        $this->processo = $this->getBD("importacoes_processos", "first", array("conditions" => array("processo" => $processo)));
    }
    
    public function startFromProcesso($modulo, $processo) {
        $this->modulo = $modulo;
        switch ($this->modulo){
            case "importacao":
                $this->processo = $this->getBD("importacoes_processos", "first", array("conditions" => array("processo" => $processo)));
                break;
        }
        
        
        $this->setEmit();
        $this->autoSetDest();
        $this->autoSetDetImportacao();
        $this->autoSetTransp();
        $this->renderXml();
    }

    private function setEmit() {
        $authComponent = ClassRegistry::load("AuthComponent", "Component");
        $authComponent = $authComponent->user();
        $xMun = $this->getBD("sys_municipios", "firstById", $authComponent["empresa"]["cidade"]);
        $this->nfe["NFe"]["emit"] = array(
            "CNPJ" => $this->clearField($authComponent["empresa"]["cnpj"]),
            "xNome" => $authComponent["empresa"]["razaoSocial"],
            "xFant" => $authComponent["empresa"]["nomeFantasia"],
            "enderEmit" => array(
                "xLgr" => $authComponent["empresa"]["endereco"],
                "nro" => $authComponent["empresa"]["nro"],
                "xCpl" => $authComponent["empresa"]["complemento"],
                "xBairro" => $authComponent["empresa"]["bairro"],
                "cMun" => $authComponent["empresa"]["cidade"],
                "xMun" => $xMun["nome"],
                "UF" => $this->optionEstados[$authComponent["empresa"]["estado"]],
                "CEP" => $this->clearField($authComponent["empresa"]["cep"]),
                "cPais" => "1058",
                "xPais" => "Brasil",
                "fone" => $this->clearField($authComponent["empresa"]["fone"])
            ),
            "IE" => $this->clearField($authComponent["empresa"]["ie"]),
            "IM" => $this->clearField($authComponent["empresa"]["im"]),
            "CNAE" => $this->clearField($authComponent["empresa"]["cnae"]),
            "CRT" => $authComponent["empresa"]["crt"]
        );
    }

    private function getBD($model, $funcao, $condicao) {
        $bd = ClassRegistry::load($model, "Model");
        $dado = $bd->$funcao($condicao);
        return $dado;
    }

    private function clearField($value) {
        $value = preg_replace("/[^A-Za-z0-9_]/", "", $value);

        return $value;
    }

    private function autoSetDest() {
        //buscar na tabela comercial
        $dest = $this->getBD("comercial_clientes", "firstById", $this->processo["cliente_id"]);

        $xMun = $this->getBD("sys_municipios", "firstById", $dest["cidade"]);

        $this->nfe["NFe"]["dest"] = array(
            "CNPJ" => $this->clearField($dest["cnpj"]),
            "xNome" => $dest["razaoSocial"],
            "enderDest" => array(
                "xLgr" => $dest["endereco"],
                "nro" => $dest["nro"],
                "xCpl" => $dest["complemento"],
                "xBairro" => $dest["bairro"],
                "cMun" => $dest["cidade"],
                "xMun" => $xMun["nome"],
                "UF" => $this->optionEstados[$dest["estado"]],
                "CEP" => $this->clearField($dest["cep"]),
                "fone" => $this->clearField($dest["fone"])
            ),
            "IE" => $this->clearField($dest["ie"]),
            "ISSUF" => $dest["ISSUF"],
            "email" => $dest["email"]
        );
    }

    public function setDest($dest) {
        //recebe de um formulário
        $this->nfe["NFe"]["dest"] = array(
            "CNPJ" => $this->clearField($dest["cnpj"]),
            "xNome" => $dest["razaoSocial"],
            "enderDest" => array(
                "xLgr" => $dest["endereco"],
                "nro" => $dest["nro"],
                "xCpl" => $dest["complemento"],
                "xBairro" => $dest["bairro"],
                "cMun" => $dest["cidade"],
                "xMun" => $xMun["nome"],
                "UF" => $this->optionEstados[$dest["estado"]],
                "CEP" => $this->clearField($dest["cep"]),
                "fone" => $this->clearField($dest["fone"])
            ),
            "IE" => $this->clearField($dest["ie"]),
            "ISSUF" => $dest["ISSUF"],
            "email" => $dest["email"]
        );
    }

    private function autoSetDetImportacao() {
        $produtos = $this->getBD("importacoes_produtos", "all", array("conditions" => array("processo" => $this->processo["processo"])));
        
        $nItem = 1;
        $sufixos = array("Entrada", "Saida");
        $sufixosIcms = array("Interna", "Interestadual");

        foreach ($produtos as $produto) {
            $sufix = $sufixos[$this->nfe["NFe"]["ide"]["tpNFe"]];
            $sufixIcms = $sufixosIcms[$this->nfe["NFe"]["ide"]["tpNFe"]];
            $orig = substr($produto["cst"], 0, 1);
            $cst = substr($produto["cst"], 1, 3);
            if($this->processo["destinacao"]==2){
                $cst = "00";
            }
            switch ($cst) {
                case "00":
                    $tagIcms = array(
                        "ICMS$cst" => array(
                            "orig" => $orig,
                            "CST" => $cst,
                            "modBC" => "0",
                            "vBC" => $produto["baseIcms$sufix"],
                            "pICMS" => $produto["aliqIcms$sufixIcms"],
                            "vICMS" => $produto["icms$sufix"]
                        )
                    );
                    break;
                case "10":
                    $tagIcms = array(
                        "ICMS$cst" => array(
                            "orig" => $orig,
                            "CST" => $cst,
                            "modBC" => "0",
                            "vBC" => $produto["baseIcms$sufix"],
                            "pICMS" => $produto["aliqIcms$sufixIcms"],
                            "vICMS" => $produto["icms$sufix"],
                            "modBCST" => "",
                            "vBCST" => "",
                            "pICMSST" => "",
                            "vICMSST" => ""
                        )
                    );
                    break;
                case "20":
                    $tagIcms = array(
                        "ICMS$cst" => array(
                            "orig" => $orig,
                            "CST" => $cst,
                            "modBC" => "",
                            "pRedBC" => "",
                            "vBC" => "",
                            "pICMS" => "",
                            "vICMS" => ""
                        )
                    );
                    break;
                case "30":
                    $tagIcms = array(
                        "ICMS$cst" => array(
                            "orig" => $orig,
                            "CST" => $cst,
                            "modBCST" => "",
                            "vBCST" => "",
                            "pICMSST" => "",
                            "vICMSST" => ""
                        )
                    );
                    break;
            }


            $this->nfe["NFe"]["det"][$nItem] = array(
                "prod" => array(
                    "prod" => array(
                        "cProd" => $produto["id"],
                        "cEAN" => $produto["ean"],
                        "xProd" => $produto["descricao"],
                        "NCM" => $this->clearField($produto["ncm"]),
                        "EXTIPI" => "",
                        "CFOP" => "",
                        "uCOM" => "",
                        "qCOM" => "",
                        "vUnCom" => "",
                        "vProd" => "",
                        "cEANTrib" => "",
                        "uTrib" => "",
                        "qTrib" => "",
                        "vUnTrib" => "",
                        "vFrete" => "",
                        "vSeg" => "",
                        "vDesc" => "",
                        "vOutro" => "",
                        "indTot" => "",
//                    "xPed"=>"",
//                    "nItemPed"=>""
                    ),
                    "imposto" => array(
                        "ICMS" => $tagIcms,
                        "IPI" => array(),
                        "II" => array(),
                        "PIS" => array(),
                        "PISST" => array(),
                        "COFINS" => array(),
                        "COFINSST" => array(),
                        "ISSQN" => array()
                    )
                )
            );
            $nItem++;
        }
    }

    public function addProd($id) {
        
    }

    public function delProduto($id) {
        
    }

    public function fat($fat = array(), $dup = array()) {
        if (!empty($fat))
            $this->nfe["NFe"]["cobr"]["fat"] = $fat;

        if (!empty($dup))
            $this->addDup($dup);
    }

    public function addDup($dup) {
        if (count($dup) > 1) {
            foreach ($dup as $duplicata) {
                $this->nfe["NFe"]["cobr"]["dup"] = array(
                    "nDup" => $duplicata["nDup"],
                    "dVenc" => $duplicata["dVenc"],
                    "vDup" => $duplicata["vDup"]
                );
            }
        } else {
            if (!empty($dup[0]["id"])) {
                
            }
        }
    }

    public function getDup($nfe, $dup) {
        
    }

    private function autoSetTransp() {
        switch ($this->modulo){
            case "importacao":
                $frete = $this->getBD("importacoes_nacionalizacao", "first", array("conditions" => array("custo_id" => "13", "processo" => $this->processo["processo"])));
                break;
        }
        
        if (!empty($frete)) {
            $modFrete = "1";
        } else {
            $modFrete = "0";
        }
        $this->nfe["NFe"]["transp"] = array(
            "modFrete" => $modFrete
        );
    }
    
    public function setTransp($transp){
        $this->nfe["NFe"]["transp"] = array(
            "modFrete" => $modFrete
        );
    }

}

?>