<?php
//error_reporting(E_ALL);
/**
-----------------------------------------------------------------
        KNOWN BUGS
-----------------------------------------------------------------

    isImage() está sendo chamada duas vezes quando usado o método cell() e seus
    parâmetros não são recebidos se o nome da imagem vier do banco de dados. A
    soluçao é repassar os parâmetros para o extract() e manter somente o
    isImage() contido no extract(). extract() também precisa receber os parâmetros
    para poder funcionar, ou então pegar diretamente da variável global. cell()
    precisa deixar de gerar o "FINAL" e manter somente o array normal na variável global.

-----------------------------------------------------------------
        CHANGELOG
-----------------------------------------------------------------
    1.0 Inicial

    2.0
      16/06/2010
      [+] startFromSql() inicia um datagrid a partir de uma consulta
        direta do banco
      [m] extract() agora também casa campos com números, hífens e
       underscore. Reportado por Osmar Alves:
       (http://forum.spaghettiphp.org/topics/view/1812#topic-2234)

      25/08/2010
      [m] Retirado o suporte ao 0.1 em conditions. Operadores de
       comparação não estavam funcionando.
      [m] slice() não corta mais a palavra no meio.
      [m] cell() dava pau quando tentava inserir uma imagem.

      14/09/2010
      [m] title() agora aceita um array como parâmetro, podendo
        gerar um texto, imagem, link e passar demais parâmetros
        para a imagem.

      27/09/2010
      [+] radio() configura o campo a ser exibido como um radiobutton
      [m] checkbox() não tava sendo gerado com o nome corretamente
      [m] checkbox() agora não precisa do nome nem de um valor padrão.
        Esses dados serão recebidos diretamente da coluna, caso não
        sejam informados e caso a coluna seja advinda da consulta.

      09/10/2010
      [m] hidden() pode receber como parâmetro um array contendo uma lista
           de campos a serem ocultados. Caso não seja informado o parâmetro,
           somente o campo atual ($this->nowCol) ficará oculto.


-----------------------------------------------------------------
        TO DO
-----------------------------------------------------------------

    - repeatAfter() permitirá repetir o cabeçalho após uma quantidade
    "x" de linhas.

    - pageFooter() e reportFooter() permitirão gerar rodapés da página
    e do relatório completo.

    - adicionar regex nas opções de comparação

    - searchable() habilita a classe para fazer buscas nas colunas,
    inserindo textboxes nas colunas para fazer a filtragem

    - paginable() habilita a classe para inserir paginação nos resultados



*/
class XgridHelper extends HtmlHelper{
/*
$columns
Guarda as colunas no seguinte formato
    $column = array(
        'name' => array(

            //Nome que aparecerá na coluna
            'label' => 'editar',

            //Título da coluna
            'title' => 'Editar',

            //a coluna foi adicionada ou já vem do array original?
            'added' => false,

            //valor final já em html para exibição final na célula
            'value' => ''

            //a coluna será oculta
            'hidden'=> true,

            //formato de exibição, como currency, integer, image
            'configs'=>array(
                'type' => 'currency', 'dig'=>2, 'dec'=>',', 'mil'=>'.'),
                'type' => 'calc', 'formula'=>'{id}*2',

                //checked recebe um valor do BD, mas deve ser 1 ou 0
                //pra funcionar
                'type' => 'checkbox', 'value'=>1, 'checked' => {ativa}
),
);

*/
private $columns = array();
/*
        $data
        - Guarda os dados vindos do banco de dados
        [0] => array(id=> 1, nome=>klawdyo, password=>324jhg23jj4g32j4g3jf) ,
        [1] => array(id=> 2, nome=>spatest, password=>324jhg23j4hg3232j4g3jh) ,
*/
private $data = array();

    /**
      * Coluna atual
      */
    private $nowCol = null;

    /**
      * AutoNumeração
      * - Permite incluir autonumeração vários campos
      */
    private $autoNum = array();

    /**
      * Exibe os erros ou nao. 0 = nao, 1 = exibe um warning
      */
    private $showErrors = 1;

    /**
      * Alternar classes nas linhas da coluna?
      *
      * formato:
      * array( 'alternate' => true, '0' => 'amarela', '1' => 'branca' )
      */
    private $alternate = NULL;
    

    /**
      * Class CSS a ser aplicada ao elemento <table> por padrão
      */
       
    private $tableClass = 'datagrid';

    /**
      * Class CSS a ser aplicada a cada uma das linhas
      *
      * formato:
      * array(0 => 'bg-green', 4 => 'bg-red')
      *
      * Nesse exemplo, somente seriam aplicadas classes às
      * linhas 0 e 4 dentro do conjunto de resultados vindos do
      * banco de dados, ou seja, não estamos contando com a linha
      * de cabeçalho. Essa preocupação é transparente ao programador
      * usuário deste helper.
      */
    private $rowClass = array();

    /**
      * Class CSS para usar nas células específicas, acessível
      * através do método conditions()
      */
    private $cellClass = array();

    /**
      * Class CSS para usar no <tr> do rodapé
      */
    private $footerClass = null;

    /**
      * A tabela é ordenável?
      * A ordenação pode ser automática, ou manual. Se for utilizado
      * o método startFromModel() para iniciar o helper, então a
      * ordenação será feita automaticamente se essa variável for true.
      */
    private $sortable = false;

    /**
      * Guarda os parâmetros da url
      */
    private $urlParams = array();

    /**
      * Class CSS para usar na coluna definida.
      *
      * formato:
      * array('nome-coluna' => 'bg-red', 'outra-coluna' => 'bg-green')
      *
      * Nesse exemplo, a coluna 'nome-coluna' receberá a classe 'bg-red'
      * e a coluna 'outra-coluna' receberá a class 'bg-green'. Essa
      * propriedade é acessível através do método colClass()
      */
    private $colClass = array();
    
    private $editable = false;

    /**
      * Texto/HTML para ser usado quando não houverem dados para exibir.
      * Os dados serão guardados nessa propriedade em formato final, ou
      * seja, já em um html formatado, pronto pra exibir.
      */
    private $noData = "Nenhum Registro Encontrado";

    /**
      * Guarda as colunas definidas como cabeçalho de linha.
      */
    private $asRowHeader = array();


    /**
      * Tem rodapé?
      */
    private $hasFooter = false;

    /**
      * Guarda as configurações do rodapé
      */
    private $configFooter = false;

    /**
      * Estou editando o que? Uma coluna ou um rodapé?
      * Valores: col ou footer
      */
    private $nowType;

    /******************************************************************************

                    MÉTODOS PRINCIPAIS

    *******************************************************************************/
    
    /**
      * Imprime a tabela
      *
      * @return object
      */
    public function __toString(){

        //Se não houver dados para mostrar, e se noData NÃO for null
        //if(empty($this->data)) return empty($this->noData) ? '' : $this->noData;

        //Variáveis opcionais
        $class = (!empty($this->tableClass)) ? ' class="' . $this->tableClass . '"' : '';
        $summary = (!empty($this->summary)) ? ' summary="' . $this->summary . '"' : '';
        $caption = (!empty($this->caption)) ? ' <caption>' . $this->caption . '</caption>' : '';

        $html = "\n<table{$class}{$summary} cellspacing='0'>{$caption}\n";

        //imprimindo o cabeçalho
        $html .= $this->printHeader();

        $html .= "\t<tbody>\n";

        //Imprimindo o corpo da tabela pra cada linha de
        //$this->data como key $row e value $arr
        foreach($this->data as $row => $data):
            $rowData = '';

            foreach($this->columns as $col => $arr):
                //Pula o campo hidden
                if(isset($arr['hidden']) && $arr['hidden'] === true) continue;

                //Dados formatados da célula que será impressa agora
                $rowDataFormated = $this->format($col, $row);

                //Se tiver uma class a ser aplicada a essa célula
                $cellClass = isset($this->cellClass[$col][$row]) ?
                    'class="' . $this->cellClass[$col][$row] . '" ' : '';

                //Se tiver uma class a ser aplicada a essa coluna completa
                if(!isset($this->cellClass[$col][$row]) && isset($this->colClass[$col])):
                    $cellClass = 'class="'. $this->colClass[$col] .'" ';

                //Se tiver uma class para essa célula e também
                //para essa coluna, aplica as duas.
                elseif(isset($this->cellClass[$col][$row]) && isset($this->colClass[$col])):
                    $cellClass = 'class="'. $this->cellClass[$col][$row] .' '. $this->colClass[$col] .'" ';
                endif;

                //A coluna atual foi marcada como título de linha?
                $asRowHeader = (isset($this->asRowHeader[$col])) ? 'th' : 'td';

                //Imprimindo cada uma das células
                $rowData .= "\t\t\t<{$asRowHeader} {$cellClass}"
                            . "headers=\"" . $this->columns[$col]['id'] . "\">"
                            . $rowDataFormated . "</{$asRowHeader}>\n";

            endforeach;

            //Se tiver uma class condicional para essa linha específica
            if(isset($this->rowClass[$row])):
                $rowClass = ' class="'. $this->rowClass[$row] .'"';

            //Se definir uma class alternada
            elseif($this->alternate !== NULL):
                $rowClass = ' class="'. $this->alternate[$row % 2] .'"';

            //Se nenhuma class é aplicável
            else:
                $rowClass = '';
            endif;
           //Define a classe alternada das linhas
            $html .= "\t\t<tr{$rowClass}>\n";
            $html .= $rowData;
            $html .= "\t\t</tr>\n";
        endforeach;
        if(empty($this->data)){
            $contaColuna = count($this->columns);
            $html .= "\t\t<tr{$rowClass}> <td colspan={$contaColuna} class='noData'>\n";
            $html .= $this->noData;
            $html .= "\t\t</td></tr>\n";
        }
        $html .= "\t</tbody>";

        //Imprimindo o rodapé da tabela
        $html .= $this->printFooter();

        $html .= "\n</table>\n";

        //Resetando as configurações antes de imprimir
        $this->reset();

        return $html;
    }

    /**
      * Imprime o cabeçalho
      *
      * @return string
      */
    private function printHeader(){
        $html = "\t<thead>\n\t\t<tr>\n";

        $merge = 0;
        //imprimindo o header
        foreach($this->columns as $col => $arr):
            if(isset($arr['hidden']) && $arr['hidden'] === true): continue; endif;
            if($merge > 1): $merge --; continue; endif;

            if(isset($this->columns[$col]['merge']) && $this->columns[$col]['merge'] <> 0):
                $merge = $this->columns[$col]['merge'];
                $colspan = ' colspan="'. $this->columns[$col]['merge'] .'"';
            else:
                $colspan = '';
            endif;

            //Adicionando um id a cada uma dos títulos das colunas
            $html .= "\t\t\t<th{$colspan} id=\"" . $this->columns[$col]['id'] . "\">";

            $html .= ($this->sortable === true)?
                $this->applySortable($col) : $this->columns[$col]['title'];
            $html .= "</th>\n";
        endforeach;

        $html .= "\t\t</tr>\n\t</thead>\n";
        return $html;
    }

    /**
      * Imprime o rodapé da tabela
      *
      * @return string
      */
    private function printFooter(){
        if($this->hasFooter === false) return;

        $class = ($this->footerClass) ? ' class="' . $this->footerClass . '"' : '';

        $html = "\n\t<tfoot>";
        $html .= "\n\t\t<tr{$class}>";

        $merge = 0;
        foreach($this->columns as $col => $value):
            if($value['hidden'] === true): continue; endif;
            if($merge > 1): $merge --; continue; endif;

            if($this->configFooter[$col]['merge'] <> 0):
                $merge = $this->configFooter[$col]['merge'];
                $colspan = ' colspan="'. $this->configFooter[$col]['merge'] .'"';
            else:
                $colspan = '';
            endif;

            $html .= "\n\t\t\t<td{$colspan}>";
            $html .= $this->configFooter[$col]['final'];
            $html .= "</td>";
        endforeach;

        $html .= "\n\t\t</tr>";
        $html .= "\n\t</tfoot>";

        return $html;
    }

    /**
      * Retorna o valor da coluna baseado em seu valor e suas configurações.
      * esse método é chamado a cada célula para retornar os valores já formatados
      *
      * @param integet $col O número da coluna
      * @param integer $row O número da linha
      * @return string Valor já formatado para a célula
      */
    private function format($col, $row){
        $data = $this->data[$row];
        $nowdata = isset($data[$col]) ? $data[$col] : '';
        $column = $this->columns[$col]; //coluna atual
        $configs = $column['configs'];
        $type = $configs['type'];

        //se já tiver um padrão definido para o campo, bastando substituir pelos valores
        $final = isset($column['final']) ? $column['final'] : false;
        $conditions = isset($column['conditions']) ? $column['conditions'] : false;

        if($final):
            return $this->extract($final, $row);

        elseif($conditions):
            return $this->applyConditions(key($conditions), reset(array_values($conditions)), $row);

        elseif(isset($type)):
            $extracted = $this->extract($nowdata, $row);//Valor atual já substituídos os {}

            switch($type):
                //
                case 'calc':
                    return $this->applyCalc($configs['formula'], $row);
                break;
                //
                case 'currency':
                    return $this->applyCurrency($configs, $extracted);
                break;
                case 'calcCurrency':
                    return $this->applyCurrency($configs, $this->applyCalc($configs['formula'], $row));
                    break;
                //
                case 'date':
                    return $this->applyDate($configs['new_format'], $nowdata);
                break;
                //
                case 'slice':
                    return $this->applySlice(
                        $configs['num'], $configs['complement'], $extracted);
                break;
                //
                case 'autonum':
                    return $this->autoNum[$col]++;
                break;
                //
                case 'text':
                    return $nowdata;
                break;
                case 'array':
                    if(!is_null($configs["key2"])){
                        return $nowdata[$configs["key"]][$configs["key2"]];
                    }else{
                        return $nowdata[$configs["key"]];
                    }
                    
                    break;
            endswitch;
        else:
            return $nowdata;
        endif;
    }

    /**
      * Inicia a configuração do datagrid a partir do recebimento do
      * array com os dados, e também gera a lista de colunas inicial.
      *
      * @param array $results A listagem vinda do banco de dados
      * @return object
      */
    public function start($results){
        $this->data = $results;

        //Pego só o primeiro elemento dos resultados para usar suas colunas
        $first = !empty($results) ? reset($results) : array();

        //Gero a listagem de colunas, adicionando seus valores
        //iniciais padrão através do método $this->col()
        foreach($first as $col => $value):
            $this->col($col);
        endforeach;

        return $this;
    }

    /**
      * Inicia a configuração das colunas a partir de uma sql
      *
      * @param string $sql Sql colocada diretamente na consulta
      * @return object
      */
    public function startFromSql($sql){
        preg_match('/from (?<table>[a-z0-9_-]+)/i', $sql, $output);

        $model = Inflector::camelize($output['table']);

        if($results = Loader::instance('Model', $model)):
            $results = $results->fetch($sql);
        else:
            $this->error("Model don't exists in app/models/{$model}.php");
        endif;

        $this->start($results);

        return $this;
    }

    /**
      * Inicia a configuração das colunas a partir de uma consulta a
      * um model
      *
      * @param array $model O model em que será feita a busca
      * @param array $conditions Os parâmetros de configuração para a
      * busca no model
      * @return object
      */
    public function startFromModel($model, $params = array()){
        //Inicia os parâmetros da url
        $this->urlParams();

        //$model = ClassRegistry::load($model, 'Model'); //v 0.1
        $model = Loader::instance('Model', $model); //v 0.2

        $order = isset($this->urlParams['named']['order']) ?
            ($this->urlParams['named']['order']) : $model->primaryKey;

        $order.= isset($this->urlParams['named']['by']) ?
                        ' ' . ($this->urlParams['named']['by']) : ' ASC';

        $model->order = $order;
        $this->start($model->all($params));

        return $this;
    }

    /**
      * Retorna o foco do encadeamento para uma coluna e cria os
      * campos-base para as formatações posteriores
      *
      * @param string $name O nome da coluna
      * @return object
      */
    public function col($name){
        $this->nowCol = $name;
        $this->nowType= 'col';

        $this->columns[$name] = array(
            'title' => Inflector::humanize($name), //o título da coluna
            'configs'=> array('type'=>'text'), //configurações do campo.
            'id' => 'header-' . Inflector::slug($name), //O id do campo: header-nome-campo
        );

        return $this;
    }

    /**
      * Retorna o encadeamento para uma célula do rodapé
      *
      * @param optional string $name O nome da coluna,
      * referindo-se ao seu rodapé que deve receber o
      * encadeamento. Caso $name não seja informado, valerá
      * o valor atual da coluna, já que as duas formas a
      * seguir são suportadas:
      *
      * //Utilizará o rodapé da coluna "id", e somará seus valores.
      * ->footer('id')->sum()
      *
      * //O encadeamento inicia na coluna "id" e ao chamar footer(), este passa
      * //para o rodapé, mas mantém-se na mesma coluna "id", e exibe a contagem
      * //dos valores.
      * ->col('id')->footer()->count()
      * @return object
      */
    public function footer($name = null){
        $name = empty($name) ? $this->nowCol : $name;

        $this->nowFooter = $name;
        $this->hasFooter = true;
        $this->nowType= 'footer';

        return $this;
    }

    /**************************************************************************

                        MÉTODOS SECUNDÁRIOS

    ***************************************************************************/


    /************************************************************
        MÉTODOS DE CONFIGURAÇÃO E FORMATAÇÃO DE COLUNAS
    ************************************************************/

    /**
      * Cria uma coluna de autonumeração
      *
      * @param int $start Número que inicia a contagem
      * @return object
      */
    public function autonum($start = 1){
        $this->autoNum[$this->nowCol] = $start;

        $this->columns[$this->nowCol]['configs'] = array(
            'type' => 'autonum',
        );

        return $this;
    }

    /**
      * Calcula uma fórmula definida em $formula
      *
      * É possível fazer cálculos matemáticos. Por exemplo, o exemplo
      * abaixo cria uma coluna chamada 'valor_total', que exibirá a
      * multiplicação da quantidade de itens pelo valor unitário.
      * A fórmula pega o valor de um campo chamado valor_unitario e
      * multiplica pelo campo qtd.
      * $xgrid->col('valor_total')->calc({valor_unitario}*{valor_total})
      *
      * Obs.: Os cálculos só funcionam corretamente se usarmos colunas
      * de dados vindas do BD, ou seja, não é possível fazer cálculos
      * usando como parâmetros outros campos calculados
      *
      * Também é possível usar calc() para criar exibições condicionais.
      * O exemplo a seguir, verifica o valor do campo "status", se este
      * for igual a "open", exibe um link para fechar, e se for "closed",
      * exibe o texto "fechado"
      * ->col('test')
      * ->calc('({status}==open)? "<a href=\"/close/{id}\"\>[x]<a/\>" : fechado')
      *
      * Obs.: Isso é só um exemplo. Para formatações condicionais,
      * recomendamos usar o método XgridHelper::conditions()
      *
      * @param string $formula A fórmula que será analisada.
      * @return object
      */
    public function calc($formula){
        $this->columns[$this->nowCol]['configs'] = array(
            'type' => 'calc',
            'formula' => $formula,
        );

        return $this;
    }

    public function cellArray($key, $key2=null){
        
            $this->columns[$this->nowCol]['configs'] = array(
            'type' => 'array',
            'key' => $key,
            'key2'=>$key2
        );
        
        return $this;
    }

    /**
      * Configura uma célula para ser exibida como texto, imagem, link,
      * ou imagem com link.
      * XgridHelper::cell() aceita personalização de valores. Para
      * usar o valor de qualquer um dos campos para personalizar outro,
      * é só passá-lo entre chaves: {}.
      *
      * Exemplos de uso
      * Mostra um texto padrão
      * ->cell('texto padrão')
      * Mostra um texto personalizado com a data de criação vinda do BD
      * ->cell('texto criado em {created}')
      * Mostra o texto 'texto' como um link para a url '/url/do/link'
      * ->cell('texto', '/url/do/link')
      * Detecta a partir da extensão que trata-se de uma imagem, e a exibe.
      * Imagens são relativas a /public/images
      * ->cell('/foto1.jpg')
      * Mostra uma imagem fixa com link
      * ->cell('/foto1.jpg', '/url/do/link')
      * Mostra uma imagem baseado em algum dado das colunas
      * ->cell('/img-{status}.jpg')
      * Mostra uma imagem com um link e um texto alternativo
      * ->cell('/img-ok.jpg', '/link/pra/algum/lugar', array('alt'=>'texto alternativo'))
      *
      * @param string $label Sempre é o texto que será exibido.
      * se for uma imagem, exibe a imagem
      * @param string $href Sempre que existir, trata-se de um link
      * @param array $params Parâmetros adicionais
      * @return object
      */
    public function cell($label, $href = null, $params = array()){
        //Verifica tratar-se de uma imagem, e a exibe se for o caso
        $label = $this->isImage($label, $params);

        //Cria o valor final para o campo
        $this->columns[$this->nowCol]['final'] =
            (!empty($href)) ? $this->link($label, $href,$params,true) : $label;

        return $this;
    }

    /**
      * Configura a célula para ser exibida como checkbox
      *
      * @version
      * 0.1 Inicial
      * 0.2 27/09/2010
      * - Não estava gerando o nome para o checkbox
      * - O valor padrão agora é NULL. Caso nada seja definido, será
      * aplicado o valor da própria coluna, caso seja uma coluna vindo
      * do banco de dados
      * - Caso nenhum nome seja definido, a própria coluna nomeará o
      * checkbox criado
      *
      * @param string $name O nome do checkbox. Por padrão é o próprio nome
      * da coluna
      * @param string $value O atributo value do checkbox. Por padrão é o
      * próprio valor da coluna, caso esta venha do banco de dados
      * @param array $params Parâmetros para o checkbox criado
      * @return object
      */
    public function checkbox($name, $value = null, $params = array()){
        //Se nenhum nome for definido, a própria coluna será o nome
        if(empty($name)):
            $name = $this->nowCol;
        endif;

        //Se nenhum valor for definido, será verificado se a coluna vem do
        //banco de dados, e este será seu valor caso venha.
        if(empty($value)):
            if(!$this->isNewColumn($this->nowCol)):
                $value = '{' . $this->nowCol . '}';
            endif;
        endif;

        $this->columns[$this->nowCol]['final'] =
            $this->tag('input', null,
                array_merge(array('name' => $name, 'value'=>$value,
                                  'type' => 'checkbox'), $params), false);
        return $this;
    }

    /** @todo
      * Adiciona uma função a ser executada em todas as linhas.
      *
      * @version
      * 0.1 27/09/2010 Inicial
      *
      *
      * @return object
      */
    public function func($name = null, $value = null, $params = array()){
        return $this;
    }

    /**
      * Configura a célula para ser exibida como radiobutton
      *
      * @version
      * 0.1 27/09/2010 Inicial
      *
      * @param string $name O nome do radiobutton. Por padrão, o próprio
      * nome da coluna será o nome do radiobutton.
      * @param string $value O atributo value do radiobutton. O padrão é o
      * próprio valor da coluna, caso a coluna venha do banco de dados.
      * Se for uma coluna calculada é necessário definir um valor.
      * @param array $params Parâmetros para o radiobutton criado
      * @return object
      */
    public function radio($name = null, $value = null, $params = array()){
        //Se nenhum nome for definido, a própria coluna será o nome
        if(empty($name)):
            $name = $this->nowCol;
        endif;

        //Se nenhum valor for definido, será verificado se a coluna vem do
        //banco de dados, e este será seu valor caso venha.
        if(empty($value)):
            if(!$this->isNewColumn($this->nowCol)):
                $value = '{' . $this->nowCol . '}';
            endif;
        endif;

        //Adiciono o valor padrão ao final, que será submetido ao extract()
        //antes de ser impresso para substituir os "{}" pelos valores corretos.
        $this->columns[$this->nowCol]['final'] =
            $this->tag('input', null,
                array_merge(array('name' => $name, 'value'=>$value,
                                  'type' => 'radio'), $params), false);
        return $this;
    }

    /**
      * Calcula o valor ou formatação de um campo baseado em condições
      * definidas.
      *
      *
      * EXEMPLOS:
      * 1) cria uma nova coluna chamada 'new_col' e define que
      * seu valor dependerá do valor contido na coluna status.
      * Se status for igual a 'open', new_col receberá um link
      * para fechá-la. Se status tiver um valor 'closed', então
      * new_col exibirá somente um texto chamado 'fechado' e
      * definirá a class daquela linha específica como 'closed',
      * que provavelmente servirá para mudar a cor de fundo.
      *
      * Obs.: Sempre que 'href' for definido, tratar-se-á de um link.
      *
      * Obs2.: Se o valor da chave 'closed'=>'uma string', será
      * exibido como tal, ou seja, para valores simples, sem
      * mudanças de classes, só é necessário colocar o próprio
      * valor diretamente.
      *
      * ->col('new_col')->conditions('status', array(
      * 'open' => array('href'=>'/dev/close/{id}', 'label'=>'[x]'),
      * 'closed'=> array('label'=>'fechado', 'rowClass'=>'closed')
      * ))
      *
      * 2) Pega a coluna chamada 'status', que já existe no banco de
      * dados e define uma condição. Nesse caso, jogamos os parâmetros
      * diretamente no primeiro parâmetro, logo o método considerará
      * que estamos usando para referência a própria coluna atual.
      * Isso só pode ser feito em colunas quem vierem do banco de
      * dados, pois colunas criadas não podem ser usadas como
      * referência para cálculos, pois seus valores ainda não existem
      * e podem variar dependendo de outros, podendo gerar uma
      * referência cíclica. Essa condição apenas altera o valor da
      * class da linha, dependendo do valor. Como não definimos
      * nenhum outro valor para href, label ou text, este não será
      * alterado.
      *
      * ->col('status')->conditions(array(
      * 'open' => array('cellClass' => 'open'),
      * 'closed'=> array('cellClass' => 'closed')
      * ))
      *
      * 3) Pega o valor do campo 'status' que veio do banco de
      * dados e aplica uma condição. Novamente definimos o parâmetro
      * $col como array, logo, ele será usado como parâmetros, e
      * $col receberá o nome da coluna atual.
      * Nesse caso, tentaremos determinar que trata-se de uma imagem.
      * - Para a chave 'open', indicamos um array com uma outra chave
      * 'label'. 'label' sempre trata-se do que será exibido, e pode
      * receber um texto ou uma imagem, e só virará link caso seja
      * definido 'href'.
      * - Já para a chave 'closed', conforme já falado anteriormente,
      * sempre que definirmos a chave como uma string, ela será
      * exibida como tal, ou seja, será atribuída ao 'label' para
      * ser modificada.
      *
      * ->col('status')->conditions(array(
      * 'open' => array('label'=>'/img-close.jpg'),
      * 'closed'=> '/images/img-re-open.jpg'
      * ))
      *
      * 4) Se só uma condição for definida, as demais permancem
      * sem alteração caso trate-se de um campo vindo do banco
      * de dados, e ficará em branco caso trate-se de uma coluna
      * calculada, já que a mesma não terá valores padrão
      *
      * ->col('status')->conditions(array(
      * 'open' => '/images/img-close.jpg',
      * ))
      *
      * 5) Se uma condição for definida com um dos operadores
      * de comparação: <, >, !=, <>, ==, <=, >=.
      * Abaixo, adicionaremos uma class para a linha que contém
      * o id < 2, e uma outra class nas células que contém o id == 4
      *
      * ->col('id')->conditions(array(
      * '< 2' => array('rowClass' => 'bg-red'),
      * '4' => array('cellClass' => 'bg-green'),
      * ))
      *
      *
      * @param string $col É o nome da coluna, cujo valor será usado
      * nas comparações. Não necessariamente $col é o nome da coluna
      * atual, pois você pode tentar adicionar uma formatação à
      * coluna atual, mas baseada no valor de outra
      * - $col pode ser nulo, nesse caso, será usada a coluna atual.
      * - Caso $col seja um array, será usada a coluna atual e $col
      * passa a armazenar o valor de $params, sendo este descartado.
      * @param array $params Precisa receber um array contendo chaves que
      * serão analisadas posteriomente.
      * @return object
      */
    public function conditions($col = null, $params = array()){
        //se $col for array, entao ele está recebendo $params, e $col
        //será a coluna atual.
        if(is_array($col)):
            $params = $col;
            $col = $this->nowCol;

        //se $col for nulo, trata-se da coluna atual
        elseif(is_null($col)):
            $col = $this->nowCol;
        endif;

        $pattern = '(^(<=|>=|!=|<>|<|>)?([ ])?([0-9]+)$)';
        $parameters = $params;

        foreach($params as $condition => $param):

            //label nao foi definido nas configuracoes
            if(!isset($param['label'])):
                $parameters[$condition]['label'] = '{' . $this->nowCol . '}';

            //$param é só uma string, logo, ela será o label
            elseif(is_string($param)):
                unset($parameters[$condition]);
                $parameters[$condition]['label'] = $param;

            //label está definido nas configuracoes
            elseif(isset($param)):
                $parameters[$condition]['label'] = $param['label'];

            endif;

            //Temos algum operador de comparação?
            if(preg_match($pattern, $condition, $out)):
                $parameters[$condition]['operator'] = empty($out[1]) ? '==' : $out[1];
                $parameters[$condition]['comparator'] = empty($out[3]) ? $condition : $out[3];
            else:
                $parameters[$condition]['operator'] = '==';
                $parameters[$condition]['comparator'] = $condition;
            endif;

        endforeach;

        $this->columns[$this->nowCol]['conditions'][$col] = $parameters;

        return $this;
    }

     /*
      * Configura o campo atual para ser exibido como formato moeda
      *
      * @param string $prefix O prefixo da moeda
      * @param string $digites O número de dígitos
      * @param string $decimalSeparator O separador decimal
      * @param string $thousandsSeparator O separador de milhar
      * @return object
      */
    public function currency($prefix='R$ ', $digites=2, $decimalSeparator=',', $thousandsSeparator='.'){
        
        $this->columns[$this->nowCol]['configs'] = array(
                'type' => 'currency',
                'prefix' => $prefix,
                'digites' => $digites,
                'decimalSeparator' => $decimalSeparator,
                'thousandsSeparator' => $thousandsSeparator
        );
        return $this;
    }
    
    public function calcCurrency($formula=null,$prefix='R$ ', $digites=2, $decimalSeparator=',', $thousandsSeparator='.'){
        
        $this->columns[$this->nowCol]['configs'] = array(
                'type' => 'calcCurrency',
                'formula'=>$formula,
                'prefix' => $prefix,
                'digites' => $digites,
                'decimalSeparator' => $decimalSeparator,
                'thousandsSeparator' => $thousandsSeparator
        );
        return $this;
    }
    /**
      * Formata uma data para o formato especificado.
      * Obs.: Essa função usa strtotime(), estando sujeita às suas
      * limitações, diferenças de configurações de locais, línguas, e
      * demais formatações de sistema, php e/ou servidor web.
      *
      * @param string $format O formato final que a data deve ter
      * @return object
      */
    public function date($format = 'd/m/Y H:i:s'){
        $this->columns[$this->nowCol]['configs'] = array(
            'type' => 'date',
            'new_format'=> $format,
        );

        return $this;
    }

    /**
      * Corta o texto de uma coluna
      *
      * @param int $num O número de caracteres permitidos
      * @param string $complement Um complemento opcional a ser exibido
      * após o corte
      * @return object
      */
    public function slice($num, $complement = '...'){
        $this->columns[$this->nowCol]['configs'] = array(
            'type' => 'slice',
            'num' => $num,
            'complement'=> $complement,
        );

        return $this;
    }


    /************************************************************
        MÉTODOS DE CONFIGURAÇÃO DAS COLUNAS
    ************************************************************/
    /**
      * Configura a coluna atual para ser exibida como título de linha.
      *
      * @return object
      */
    public function asRowHeader(){
        $this->asRowHeader[$this->nowCol] = true;

        return $this;
    }

    /**
      * Define uma class para ser aplicada a uma coluna inteira.
      * Caso alguma class já tenha sido aplicada à célula por meio
      * de XgridHelper::conditions, a class adicionada não
      * sobrescrevá, apenas adicionará. Dessa forma, a class seria
      * aplicada assim:
      * class="classAplicadaViaConditions classAplicadaViaColClass"
      *
      * @param string $class O nome da class
      * @return object
      */
    public function colClass($class){
        $this->colClass[$this->nowCol] = $class;

        return $this;
    }

    /**
      * Oculta a exibição de uma coluna, mas ela ainda continuará
      * disponível para cálculos e outras substituições
      *
      * @version 0.1 Inicial
      * 0.2 09/10/2010 hidden() agora aceita um parâmetro que contém
      * uma lista de campos que deverão ser ocultados. Se nenhum
      * parâmetro for informado, só será oculto o campo que consta
      * em $this->nowCol.
      *
      * @param Optional array $fields Array contendo os campos que deverão ser
      * ocultados
      * @return object
      */
    public function hidden($fields = array()){
        if(empty($fields)):
            $this->columns[$this->nowCol]['hidden'] = true;
        else:
            foreach($fields as $field):
                $this->columns[$field]['hidden'] = true;
            endforeach;
        endif;

        return $this;
    }

    /**
      * Mescla duas ou mais células do cabeçalho ou rodapé
      * É importante observar que $count representa o número de
      * células que serão mescladas, incluindo a célula atual, e
      * NÃO o número de células adicionais que serão mescladas
      * a essa própria célula.
      * Ex.:
      * //Juntará a célula do rodapé referente a 'id' à
      * //próxima célula, ou seja, estamos unindo DUAS células
      * ->footer('id')->merge(2)
      *
      * //Tem a mesma função acima. Quando não passamos o
      * //parâmetro para o método footer(), estamos considerando
      * //a coluna atual, nesse caso, 'id'
      * ->col('id')->footer()->merge(2)
      *
      * //Juntará 5 células no cabeçalho da tabela a partir da
      * //célula 'id', inclusive contando com ela
      * ->col('id')->merge(5)
      *
      * @param int Número de células a serem mescladas.
      * @return object
      */
    public function merge($count = 2){
        //Trata-se de uma célula do cabeçalho
        if($this->nowType == 'col'):
            $this->columns[$this->nowCol]['merge'] = $count;

        //Trata-se de uma célula do rodapé
        else:
            $this->configFooter[$this->nowFooter]['merge'] = $count;
        endif;

        return $this;
    }

    /**
      * Muda a posição de uma coluna na hora da exibição final do datagrid
      * Para a correta mudança de posição de uma coluna, algumas regras
      * devem ser observadas.
      * São elas:
      * - A contagem de posições inicia em 0
      * - Leve em consideração os campos ocultos por XgridHelper::hidden()
      * - Esse método altera diretamente a posição final, portanto não
      * dá para mover uma coluna para uma posição posterior a uma coluna
      * calculada caso ela ainda não tenha sido criada dentro do fluxo
      * normal.
      *
      * @param int $pos A nova posição que a coluna deve assumir,
      * começando do zero
      * @return object
      */
    public function position($pos){
        $cur_pos = array_search($this->nowCol, array_keys($this->columns));

        //só continua se a chave atual for diferente da desejada
        if($cur_pos !== $pos):
            $cols = $this->columns;
            $cur[$this->nowCol] = array_unset($cols, $this->nowCol);

            $this->columns = array_merge(
                array_slice($cols, 0, $pos, true)
                , $cur
                , array_slice($cols, $pos)
                );
        endif;

        return $this;
    }

    /**
      * Define os títulos das colunas como ordenáveis
      *
      * @param boolean $sortable Ordenável? True or False?
      * @return object
      */
    public function sortable($sortable = true){
        $this->urlParams();
        $this->sortable = $sortable;

        return $this;
    }


    /************************************************************
        MÉTODOS DE CONFIGURAÇÃO DAS CÉLULAS DO CABEÇALHO
    ************************************************************/

    /**
      * Altera o ID padrão da célula do título da coluna especificada
      *
      * @param string $id Id destinado à célula do título da coluna especificada
      * @return object
      */
    public function id($id){
        $this->columns[$this->nowCol]['id'] = $id;

        return $this;
    }

    /**
      * Altera o título da coluna.
      * Obs.: Ao alterar o título de uma coluna, ela continuará
      * sendo referencida pelo seu nome original nos campos
      * calculados em que forem utilizados seus valores, servindo, essa
      * alteração, apenas na hora da exibição
      *
      * @version
      * 0.1 Inicial
      * 0.2 14/09/2010
      * [bug] corrigido o erro que ocorria quando tentava inserir
      * uma imagem na versão 0.3. O método enviada NULL para
      * HtmlHelper::image(), que esperava um array, causando
      * um erro.
      *
      * [feature] Title() agora aceita textos, imagens e links,
      * bastando apenas passar as informações como array para o
      * primeiro parâmetro. Se for um texto simples, então será
      * apenas um texto normal, ou imagem se terminar com
      * .jpg, .gif ou .png.
      *
      * @param string $label Um texto ou path de uma imagem para o título
      * da coluna, relativo a /public/images/. $param pode receber um array,
      * desde que contenha, no mínimo, uma chave "href" e uma
      * "label", que serão a url do link e o texto/imagem da coluna,
      * respectivamente.
      * @return object
      */
    public function title($label){
        if(is_array($label)):
           if(array_key_exists('href', $label)):
                $this->columns[$this->nowCol]['title'] =
                    $this->link($this->isImage($label['label'], $label), $label['href']);
            else:
                $this->columns[$this->nowCol]['title'] =
                    $this->isImage($label['label'], $label);
            endif;
        else:
            $this->columns[$this->nowCol]['title'] = $this->isImage($label);
        endif;


        return $this;
    }

    /************************************************************
        MÉTODOS DE CONFIGURAÇÃO DO RODAPÉ
    ************************************************************/
    /**
      * Soma os valores da coluna indicada.
      * Caso $column não seja informado, será usada a mesma coluna
      * atual definida com footer().
      * É importante observar que o valor de $column é o nome da
      * coluna que será somada e não a coluna onde deve aparecer o resultado.
      * Este sempre aparecerá na coluna definida em footer().
      * Ex.:
      * //Retornará no rodapé da coluna 'id' o resultado da soma
      * //dos valores da própria coluna id
      * ->footer('id')->sum()
      *
      * //Retornará no rodapé da coluna 'status' o resultado da soma
      * //dos valores da coluna 'id'
      * ->footer('status')->sum('id')
      *
      * @param string $column O nome da coluna que será somada
      * @return object
      */
    public function sum($column = null){
        //Qual a coluna que será somada? Se nada for indicado,
        //a própria coluna será.
        $column = is_null($column) ? $this->nowFooter : $column;

        foreach($this->data as $col => $row):
            $sum[] = $row[$column];
        endforeach;

        $this->configFooter[$this->nowFooter]['final'] = array_sum($sum);

        return $this;
    }

    public function sumReal($column = null,$prefix="R$"){
		//Qual a coluna que serÃ¡ somada? Se nada for indicado, a prÃ³pria coluna serÃ¡.
		$column = is_null($column) ? $this->nowFooter : $column;

		foreach($this->data as $col => $row):
			$sum[] = $row[$column];
		endforeach;

                $this->configFooter[$this->nowFooter]['final'] = "<b>Total: </b>$prefix ".number_format(array_sum($sum), 2, ',', '.');
		return $this;
	}

    /**
      * Conta o número de resultados
      *
      * @return object
      */
    public function count(){
        $this->configFooter[$this->nowFooter]['final'] = count($this->data);

        return $this;
    }

    /**
      * Adiciona um html ou texto qualquer a uma célula do rodapé
      * Ex.:
      * //Adiciona paginação de resultados ao rodapé da tabela
      * ->footer('titulo')->html($paginate->next())
      *
      * @param string $html Html a ser adicionado
      * @return object
      */
    public function html($html = ''){
        $this->configFooter[$this->nowFooter]['final'] = $html;

        return $this;
    }

    /**
      * Define uma class CSS para o elemento <tr> do rodapé
      *
      * @param string $class O nome da class
      * @return object
      */
    public function footerClass($class = 'datagrid-footer'){
        $this->footerClass = $class;

        return $this;
    }


    /************************************************************
        MÉTODOS DE CONFIGURAÇÃO DE TABELA
    ************************************************************/


    /**
      * Configura a tabela para ser exibida com cores alternadas, por
      * meio da definição de classes diferentes para cada linha. Por
      * CSS, configura-se as cores desejadas.
      *
      * @param string $first_class
      * @param string $second_class
      * @return object
      */
    public function alternate($first = 'first_class', $second = 'second_class'){
        $this->alternate = array(
            'alternate' => true,
            '0' => $first,
            '1' => $second
        );

        return $this;
    }
    
    
    public function editable($val=false){
        
        $this->editable = $val;
    }

    /**
      * Define um título para a tabela. Ao contrário do elemento
      * "summary" ele é visível a quem enxerga, todos os navegadores
      * o renderizam e tecnologias assistivas lhe dão suporte. Segundo
      * http://www.acessibilidadelegal.com/13-tabelas-acessiveis.php, "o
      * elemento caption é recomendado pelos WCAG 1.0 e 2.0 com a observação
      * nesse segundo de que não se pode repetir a informação do elemento
      * caption no atributo summary."
      *
      * @param string $caption O título para a tabela
      * @return object
      */
    public function caption($caption){
        $this->caption = $caption;

        return $this;
    }
    /**
      * Define a exibição da tabela sem dados a exibir.
      *
      * @param string $text Define o texto. O padrão é "No results"
      * @param array $params Array com os parâmetros para o div que será
      * exibido no lugar da tabela
      * @return object
      */
    public function noData($text = 'No results', $params = array()){
        $params = array_merge(array('class' => 'datagrid no-results'), $params);
        $this->noData = $this->tag('div', $text, $params);

        return $this;
    }

    /**
      * Define uma class para o atributo <table>
      *
      * @param string $class O nome da classe que será usada para a tabela
      * @return object
      */
    public function tableClass($class = 'datagrid'){
        $this->tableClass = $class;

        return $this;
    }

    /**
      * Define um summary para a tabela. Summary é um resumo para os dados
      * da tabela. Ele não fica visível, mas torna a tabela mais acessível,
      * considerando que os leitores de tela leem a informação contida para
      * os usuários que os utilizam.
      *
      * Segundo a página
      * http://www.acessibilidadelegal.com/13-tabelas-acessiveis.php, "O
      * atributo summary é uma prioridade 3 do WCAG 1.0 e também anunciado
      * no WCAG 2.0, mas questionado no WCAG Samurai, por considerar que
      * toda tabela vem dentro de um contexto e que seu resumo seja
      * desnecessário. Além disso, parte das tecnologias assistivas
      * não possuem suporte para sua leitura. No entanto, a ausência
      * desse atributo no código é sempre acusada como erro pelos
      * validadores automáticos de acessibilidade. Recomendamos
      * sua utilização."
      *
      * @param string $summary Resumo da tabela.
      * @return object
      */
    public function summary($summary){
        $this->summary = $summary;

        return $this;
    }


    /************************************************************************

                MÉTODOS PRIVADOS

    *************************************************************************/


    /************************************************************
        MÉTODOS DE RETORNO
    ************************************************************/

    /**
      * Retorna o texto já aplicadas as suas condições
      *
      * @param string $col a coluna que será comparada
      * @param array $conditions array com as condições
      * @param integer $row O número da linha no array de dados
      * @return string O texto formatado e aplicado as condições
      */
    private function applyConditions($col, $conditions, $row){

        //valor dessa linha e desse campo
        $curValue = $this->data[$row][$col];

        foreach($conditions as $key => $cond):
            $params = $conditions[$key];

            //Se for acima da versão 0.2
            //if((SPAGHETTI_VERSION >= 0.2)):

                $comparison = Validation::comparison(
                    $curValue, $params['operator'], $params['comparator']);

            //Se for a versão 0.1, não suportará operadores de comparação
            //else:
            // $comparison = $curValue == $params['comparator'];
            //endif;

            //Se a comparação foi promissora
            if($comparison):

                //Se existir um label
                //$alt = isset($params['alt']) ? $params['alt'] : '';
                $label = isset($params['label']) ?
                    $this->isImage($params['label'], $params) : $curValue;

                //Se um link foi definido
                $return = isset($params['href']) ?
                    //'<a href="' . Mapper::url($params['href']) . '">' . $label . '</a>' : $label;
                    $this->link($label, $params['href']) : $label;

                //Se uma class de linha tiver definida
                if(isset($params['rowClass'])):
                    $this->rowClass[$row] = array_unset($params, 'rowClass');
                    //$this->rowClass[$row] = $params['rowClass'];
                endif;

                //Se uma classe de célula estiver definida
                if(isset($params['cellClass'])):
                    $this->cellClass[$col][$row] = array_unset($params, 'cellClass');
    // $this->cellClass[$col][$row] = $params['cellClass'];
                endif;

                $matched = true;
                break;
            endif;
        endforeach;

        //Se após o foreach achou-se o valor
        if($matched === true):
            return $this->extract($return, $row);
        else:
            return $curValue;
        endif;
    }

    /**
      * Aplica a fórmula definida no valor das colunas envolvidas e
      * devolve o resultado
      *
      * @param string $formula A formula definida
      * @param string $row O número da linha referente à coluna de dados
      * @return string Retorna o valor do cálculo
      */
    private function applyCalc($formula, $row){
        @eval( "\$val=" . $this->extract($formula, $row) . ";" );
        return $val;
    }

    /**
      * Aplica a formatação de moeda ao valor atual
      *
      * @param string $configs As configurações
      * @param string $extracted O valor final para o campo, imediatamente
      * antes da formatação
      * @return string
      */
    private function applyCurrency($configs, $extracted){
        return $configs['prefix'] . number_format($extracted,
                $configs['digites'],
                $configs['decimalSeparator'],
                $configs['thousandsSeparator']
            );
    }
    /**
      * Aplica o formato de data para o valor atual
      *
      * @param string $new_format O novo formato de data
      * @param string $original_date O valor inicial da data, antes
      * da formatação
      * @return string
      */
    private function applyDate($new_format, $original_date){
        return (empty($original_date) || $original_date == "0000-00-00")? '-' : date($new_format, strtotime($original_date));
    }

    /**
      * Recebe o texto e devolve-o cortado no tamanho especificado em $num
      * @version 0.2 25/08/2010
      * - A partir dessa versão as palavras não são mais cortadas
      *
      * @param string $num O número de caracteres permitidos
      * @param string $complement O complemento que o texto receberá
      * caso seja cortado, por exemplo, reticências.
      * @param string $text O texto que será analisado e possivelmente cortado
      * @return string
      */
    private function applySlice($length, $complement, $text){
        if(strlen($text) > $length):
            $text = substr($text, 0, $length);
            $length = strrpos($text, " ");

            return substr($text, 0, $length) . $complement;
        else:
            return $text;
        endif;


    }

    /**
      * Recebe o texto e devolve-o cortado no tamanho especificado em $num
      *
      * @param string $col O nome da coluna
      * @return string
      */
    private function applySortable($col){
        //Se for um campo criado, não pode receber paginação
        if($this->isNewcolumn($col)) return $this->columns[$col]['title'];

        //Parâmetros da URL
        $params = $this->urlParams;

        $by = (!isset($params['named']['by']) || $params['named']['by'] == 'DESC') ?
            'ASC' : 'DESC';

        return $this->link($this->columns[$col]['title'], array('order' => $col, 'by' => $by));
    }
    /**
      * Troca o que tiver dentro das chaves na variável $text pelo valor
      * da célula atual, retornada pelo cruzamento de $row com $this->nowCol
      *
      * @version
      * 0.2 16/06/2010
      * - Corrigido o padrão de busca, que só procurava pelo texto entre
      * chaves, ignorando números, hífens e underscore
      *
      * @param string $text Texto virgem, antes das substituições
      * @param integer O número da linha onde eu vou pegar esse texto
      * @return string
      */
    private function extract($text, $row){

        //Padrão de busca do {nome_campo} nas definições
        //$pattern = "(\{([a-zA-Z]+)\})"; //v 0.1
        $pattern = "(\{([a-zA-Z0-9_-]+)\})"; //v 0.2

        //Fazendo a busca que retorna um array com 2 valores, [0] contém o
        //original e [1] contém o campo sem {}
        preg_match_all($pattern, $text, $out);

        //Se não encontrar nada, encerra com o $text original
        if(empty($out[0])) return $text;

        //Se encontrou, dá um loop pela lista sem os {} para gerar
        //um array só com os valores relativos a esses campos para
        //a linha $row
        foreach($out[1] as $d):
            $ar[] = $this->data[$row][$d];
        endforeach;

        //Substitui finalmente os {nome_campo} pelo seu valor em $this->data
        $return = str_replace($out[0], $ar, $text);

        return $this->isImage($return);
    }

    /**
      * Define se é uma imagem ou não. Recebe o valor e se for uma imagem,
      * devolve seu código html.
      *
      * @param string $value Texto a ser verificado se é ou não é uma imagem
      * @param array $params Parâmetros aplicáveis às imagens
      * @return string
      */
    private function isImage($value, $params = array()){
        //Elimina possíveis chaves do array para não sujar o código da
        //imagem com atributos que não lhe pertence.
        unset($params['comparator'], $params['operator'],
              $params['label'] , $params['href'],
              $params['rowClass']) ;

        return (in_array(end(explode('.', $value)), array('jpg', 'gif', 'png'))) ?
                $this->image($value, $params) : $value;
    }

    /**
      * Erro
      *
      * @param string $msg Mensagem de erro
      * @return void
      */
    public function error($msg = 'Unknown Error'){
        trigger_error($msg, E_USER_ERROR);
    }

    private function reset(){
        $this->columns = array();
        $this->data = array();
        $this->nowCol = null;
        $this->autoNum = array();
        $this->showErrors = 1;
        $this->alternate = NULL;
        $this->tableClass = 'datagrid';
        $this->rowClass = array();
        $this->cellClass = array();
        $this->footerClass = null;
        $this->sortable = false;
        $this->urlParams = array();
        $this->colClass = array();
        $this->noData = null;
        $this->asRowHeader = array();
        $this->hasFooter = false;
        $this->configFooter = false;
        $this->nowType = null;
    }
    /**
      * Define os parâmetros da url
      *
      * @return void
      */
    private function urlParams(){
        $this->urlParams = Mapper::parse();
    }

    /**
      * É uma coluna criada em tempo de execução? True or False?
      *
      * @param string $col O nome da coluna
      * @return bool True caso seja uma coluna criada em tempo de
      * execução, e False se a coluna vier do banco de dados.
      */
    private function isNewColumn($col){
        return !array_key_exists($col, $this->data[0]);
    }
}
?>