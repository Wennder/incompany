<?php

class TrackingComponent extends Component {

    private function sessionMSC($tamanho=48) {
        $CaracteresAceitos = 'abcdef0123456789';
        $max = strlen($CaracteresAceitos) - 1;
        for ($i = 0; $i < $tamanho; $i++) {
            $retorno .= $CaracteresAceitos{mt_rand(0, $max)};
        }
        return $retorno;
    }

    public function trackingMsc($params) {
        //Define a URL de acesso ao Traking
        $url = "http://tracking.mscgva.ch/MSCTrackingData.php?e=" . base64_encode($params["trackingCode"] . "|CT||".$this->sessionMSC());
        $ch = curl_init();
        $configCurl = array(
            CURLOPT_URL => $url,
            CURLOPT_HEADER => false,
            CURLOPT_NOBODY => true,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_RETURNTRANSFER => false
        );
        curl_setopt_array($ch, $configCurl);
        $pagina = curl_exec($ch);
        echo $pagina;
        curl_close($ch);
        $dom = new DOMDocument();
        @$dom->loadHTML($pagina);
        $xpath = new DOMXPath($dom);
        $divs = $xpath->query(".//div");
        foreach ($divs as $div) {
            echo $div->getAttribute("title") . "<br>";
            echo $div->nodeValue;
        }
        echo $url . "<br><br>";
        die("OK");
    }

    public function trackingMaersk($params) {
        if (!empty($params)) {
            $fields["portlet_trackSimple_1{pageFlow.trackSimpleForm.numbers}"] = $params["trackingCode"];
            //Verifica qual o tipo de campo
            if ($params["tipo"] == "booking") {
                $fields["portlet_trackSimple_1wlw-select_key:{pageFlow.trackSimpleForm.type}"] = "BOOKINGNUMBER";
            } elseif ($params["tipo"] == "container") {
                $fields["portlet_trackSimple_1wlw-select_key:{pageFlow.trackSimpleForm.type}"] = "CONTAINERNUMBER";
            }
            //set the url, number of POST vars, POST data
            $url = "http://www.maerskline.com:80/appmanager/maerskline/public?_nfpb=true&_windowLabel=portlet_trackSimple_1&portlet_trackSimple_1_actionOverride=%2Fportlets%2Ftracking3%2Ftrack%2FtrackSimple%2FtrackSimple&_pageLabel=page_tracking3_trackSimple";

            //url-ify the data for the POST
            foreach ($fields as $key => $value) {
                $fields_string .= $key . '=' . $value . '&';
            }
            rtrim($fields_string, '&');

            $ch = curl_init();

            $configCurl = array(
                CURLOPT_POST => count($fields),
                CURLOPT_POSTFIELDS => $fields_string,
                CURLOPT_URL => $url,
                CURLOPT_HEADER => true,
                CURLOPT_NOBODY => false,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true
            );

            curl_setopt_array($ch, $configCurl);

            $pagina = curl_exec($ch);
            curl_close($ch);
            $dom = new DOMDocument();

            @$dom->loadHTML($pagina);
            $xpath = new DOMXPath($dom);
            $rows = array();
            $trs = $xpath->query(".//table[@class='lstBox']/tr");

            foreach ($trs as $tr) {
                $tds = $tr->getElementsByTagName('td');
                $date = $tds->item(8)->nodeValue;

                $eta = $ano = $date[7] . $date[8] . $date[9] . $date[10];
                $eta .= "-" . $mes = date('m', strtotime($date[3] . $date[4] . $date[5]));
                $eta .= "-" . $dia = $date[0] . $date[1];

                if (checkdate($mes, $dia, $ano)) {
                    $cols["documento"] = $tds->item(2)->nodeValue;
                    $cols["container"] = ereg_replace("[^a-zA-Z0-9]", "", $tds->item(3)->nodeValue);
                    $cols["ultimaMovimentacao"] = $tds->item(4)->nodeValue;
                    $cols["localMovimentacao"] = $tds->item(5)->nodeValue;
                    $cols["localDescarga"] = $tds->item(6)->nodeValue;
                    $cols["eta"] = $eta;

                    $rows[] = $cols;
                }
                unset($cols);
            }
            return $rows;
        } else {
            return false;
        }
    }

    public function updateEta($processo) {
        $modelConteiner = ClassRegistry::load("importacoes_conteineres");
        $condicao = array(
            "conditions" => array(
                "processo" => $processo
            )
        );
        $ctrs = $modelConteiner->first($condicao);

        echo is_callable($ctrs["transportadora"]["integracao"]);

        if (is_callable(array($this, $ctrs["transportadora"]["integracao"]))) {
            if ($result = $this->$ctrs["transportadora"]["integracao"](array("trackingCode" => $ctrs["numero"], "tipo" => "container"))) {

                $modelProcesso = ClassRegistry::load("importacoes_processos");
                $processo = $modelProcesso->first($condicao);
                $data["id"] = $processo["id"];
                $data["eta"] = $result[0]["eta"];
                if ($modelProcesso->save($data)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    public function importConteiner($armador, $documento) {
        if (!empty($armador) && !empty($documento)) {
            $modelArmador = ClassRegistry::load("estoque_transportadoras");
            $armador = $modelArmador->firstById($armador);
            if (count($armador) == 0) {
                return null;
            }

            if (is_callable(array($this, $armador["integracao"]))) {
                if ($result = $this->$armador["integracao"](array("trackingCode" => $documento, "tipo" => "booking"))) {
                    return $result;
                } else {
                    return null;
                }
            }
        }
    }

}

?>