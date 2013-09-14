<?php

class ImportacoesComponent extends Component {

    private $processo;
    private $modelProcessos;
    private $modelConteineres;
    private $modelAnexos;
    private $modelFabricantes;
    private $importacoesComponent;
    
    function __contruct() {
        $this->modelProcessos = ClassRegistry::load("importacoes_processos");
        $this->modelConteineres = ClassRegistry::load("importacoes_conteineres");
        $this->modelAnexos = ClassRegistry::load("importacoes_anexos");
        $this->modelFabricantes = ClassRegistry::load("importacoes_fabricantesprocesso");
        $this->importacoesComponent = ClassRegistry::load("ImportacoesComponent","Component");
    }
    
    public function scheudule(){
        //envio de email de atracação
        $this->emailAtracacao();
    }
    
    public function emailAtracacao($destinatario=null){
        $importacoesComponent = ClassRegistry::load("ImportacoesComponent","Component");
        $emailComponent = ClassRegistry::load("EmailComponent","Component");        
        
        $modelProcessos = ClassRegistry::load("importacoes_processos");
        $modelConfig = ClassRegistry::load("admin_config");
        $modelTemplates = ClassRegistry::load("marketing_templateemails");
        $modelConteineres = ClassRegistry::load("importacoes_conteineres");
        $modelAnexos = ClassRegistry::load("importacoes_anexos");
        $modelFabricantes = ClassRegistry::load("importacoes_fabricantesprocesso");
        
        $configModulo = $modelConfig->getConfig(5,500);
        $envios = $modelProcessos->avisoAtracacao($configModulo["cfg1"]);
        $template = $modelTemplates->firstById($configModulo["cfg2"]);
        $i=0;
        //die(pr($envios));
        foreach ($envios as $mensagem) {
                    //Lista dos CTR
                    $condicaoCTR = array(
                        "conditions" => array(
                            "processo" => $mensagem["processo"]
                        )
                    );
                    $mensagem["conteineres"] = $modelConteineres->toGrid($condicaoCTR);
                    $mensagem["documentosEmbarque"] = $modelAnexos->toGridCliente($condicaoCTR);
                    $vars = array(
                        "{nomeCliente}" => $mensagem["cliente"]["razaoSocial"],
                        "{pedidoCliente}" => $mensagem["nConfCliente"],
                        "{fornecedor}" => $modelFabricantes->listRelatorio($mensagem["processo"]),
                        "{FOB}" => $importacoesComponent->getFob($mensagem["processo"],true,false),
                        "{dataETA}" => date("d/m/Y",strtotime($mensagem["eta"])),
                        "{dataETD}" => date("d/m/Y",strtotime($mensagem["etd"])),
                        "{siteAcompanhamento}" => "",
                        "{numeroAcompanhamento}" => $mensagem["codRastreio"],
                        "{numeroProcesso}" => $mensagem["processo"],
                        "{descricaoPedido}" => $mensagem["descricaoProdutos"],
                        "{listaConteineres}" => $mensagem["conteineres"],
                        "{documentosEmbarque}" => $mensagem["documentosEmbarque"],
                        "{origem}" => $mensagem["origem"],
                        "{destino}" => $mensagem["destino"]
                    );
                    $emailMensagem["mensagem"] = strtr($template["mensagem"],$vars);
                    $emailMensagem["id_modulo"] = 5;
                    $emailMensagem["assunto"] = strtr($template["assunto"],$vars);
                    $emailMensagem["autorizadoEnvio"] = 1;
                    if(empty($destinatario)){
                        if(!$emailComponent->addToQueue($emailMensagem,$mensagem["contato"]["id"])){
                            
                        }
                    }else{
                        if(!$emailComponent->addToQueue($emailMensagem,$destinatario)){
                            
                        }
                    }
                    $dadosSalvar[] = array(
                        "id"=>$mensagem["id"],
                        "avisoAtracacao"=>"1",
                        "dtAvisoAtracacao"=>date("Y-m-d")
                    
                    );
                    
                }
                $modelProcessos->saveAll($dadosSalvar);
        
    }

    public function novoProcesso() {
        $modelProcessos = ClassRegistry::load("importacoes_processos");
        $data = array();
        $data["tipoProcesso"] = "0";
        $modelProcessos->save($data);
        $data = array();
        $data["id"] = $modelProcessos->getInsertId();
        $this->modelProcessos->id = null;
        if ($data["id"] <= 10) {
            $data["id"] = "0" . $data["id"];
        }
        $data["processo"] = date("ym") . $data["id"];
        if ($modelProcessos->save($data)) {
            return $data["processo"];
        } else {
            return false;
        }
    }

    public function getAliquotasIcms($processo) {

        $modelProcessos = ClassRegistry::load("importacoes_processos");
        $condicao = array(
            "conditions" => array(
                "processo" => $processo
            )
        );
        $aliquotas = $modelProcessos->first($condicao);

        $condicao = array(
            "conditions" => array(
                "cfop" => $aliquotas["operacao"]["cfopEntrada"]
            )
        );
        $modelCfop = ClassRegistry::load("sys_cfop");
        $aliqEntrada = $modelCfop->first($condicao);
        $condicao = array(
            "conditions" => array(
                "cfop" => $aliquotas["operacao"]["cfopEntrada"]
            )
        );
        $aliqSaida = $modelCfop->first($condicao);

        return array("aliqIcmsInternaPisCofins" => "17", "aliqIcmsInterna" => "17", "aliqIcmsInterestadual" => "4");
    }

    public function getFob($processo, $formatado = false, $cambio = false) {
        $model = ClassRegistry::load("importacoes_produtos", "Model");
        $condicao = array(
            "conditions" => array(
                "processo" => $processo
            )
        );
        $itens = $model->all($condicao);
        foreach ($itens as $item) {
            $fob = $fob + ($item["precoExterior"] * $item["qtd"]);
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
    
    public function formatMoeda($valor = 0, $prefix = "R$") {
        if (!$prefix) {
            return number_format($valor, 2, ',', '.');
        } else {
            return $prefix . " " . number_format($valor, 2, ',', '.');
        }
    }

}

?>
