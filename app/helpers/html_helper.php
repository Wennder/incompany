<?php

/**
 *  Geração automática dos elementos HTML de acordo com os dados passados.
 *
 *  @license   http://www.opensource.org/licenses/mit-license.php The MIT License
 *  @copyright Copyright 2008-2009, Spaghetti* Framework (http://spaghettiphp.org/)
 *
 */
class HtmlHelper extends Helper {

    /**
     *  Mantém uma referência à view que chamou o helper.
     */
    protected $view;

    public function __construct(&$view) {
        $this->view = & $view;
        $this->view->stylesForLayout = "";
        $this->view->scriptsForLayout = "";
    }

    /**
     *  Cria HTML para tags de abertura.
     *
     *  @param string $tag Tag a ser criada
     *  @param string $attr Atributos da tag
     *  @param boolean $empty Verdadeiro para criar uma tag vazia
     *  @return string Tag HTML
     */
    public function openTag($tag, $attr = array(), $empty = false) {
        $html = "<{$tag}";
        $attr = $this->attr($attr);
        if (!empty($attr)):
            $html .= " $attr";
        endif;
        $html .= ($empty ? " /" : "") . ">";
        return $html;
    }

    /**
     *  Cria HTML para tag de fechamento.
     * 
     *  @param string $tag Tag a ser fechada
     *  @return string Tag HMTL fechada
     */
    public function closeTag($tag) {
        return "</{$tag}>";
    }

    /**
     *  Cria HTML para tags de abertura e fechamento contendo algum conteúdo.
     * 
     *  @param string $tag Tag a ser criada
     *  @param string $content Conteúdo entre as tags inseridas
     *  @param array $attr Atributos da tag
     *  @param boolean $empty Verdadeiro para criar uma tag vazia
     *  @return string Tag HTML com o seu conteúdo
     */
    public function tag($tag, $content = "", $attr = array(), $empty = false) {
        $html = $this->openTag($tag, $attr, $empty);
        if (!$empty):
            $html .= "{$content}" . $this->closeTag($tag);
        endif;
        return $html;
    }

    /**
     *  Prepara atributos para utilização em tags HTML.
     * 
     *  @param array $attr Atributos a serem preparados
     *  @return string Atributos para preenchimento da tag
     */
    public function attr($attr) {
        $attributes = array();
        foreach ($attr as $name => $value):
            if ($value === true):
                $value = $name;
            elseif ($value === false):
                continue;
            endif;
            $attributes [] = $name . '="' . $value . '"';
        endforeach;
        return join(" ", $attributes);
    }

    /**
     *  Cria um link para ser utilizado na aplicação.
     * 
     *  @param string $text Conteúdo para o link
     *  @param string $url URL relativa à raiz da aplicação
     *  @param array $attr Atributos da tag
     *  @param boolean $full Verdadeiro para gerar uma URL completa
     *  @param boolean $anchor Verdadeiro para gerar um link interno da pagina

     *  @return string Link HTML
     */
    public function link($text, $url = null, $attr = array(), $full = false, $anchor = false) {
        if (is_null($url)):
            $url = $text;
        endif;
        $attr["href"] = Mapper::url($url, $full);
        if ($anchor) {
            $attr["href"] = $url;
        }
        return $this->output($this->tag("a", $text, $attr));
    }

    /**
     *  Cria um elemento de imagem para ser na aplicação.
     * 
     *  @param string $src Caminho da imagem
     *  @param array $attr Atributos da tag
     *  @param boolean $full Verdadeiro para gerar uma URL completa
     *  @return string HTML da imagem a ser inserida
     */
    public function image($src, $attr = array(), $full = false) {
        $attr = array_merge(
                array(
            "alt" => "",
            "title" => isset($attr["alt"]) ? $attr["alt"] : ""
                ), $attr
        );
        if (!$attr["bd"]) {
            if (!$this->external($src)):
                $src = Mapper::url("/images/" . $src, $full);
            endif;
        }
        $attr["src"] = $src;
        return $this->output($this->tag("img", null, $attr, true));
    }

    /**
     *  Short description.
     *
     *  @param string $src
     *  @param string $url
     *  @param array $img_attr
     *  @param array $attr
     *  @param boolean $full
     *  @return string
     */
    public function imagelink($src, $url, $img_attr = array(), $attr = array(), $full = false) {

        return $this->link($this->image($src, $img_attr, $full), $url, $attr, $full);
    }

    /**
     *  Cria elementos de folha de estilho para serem usados no HTML.
     * 
     *  @param string $href Caminho da folha de estilo a ser inserida no HTML
     *  @param array $attr Atributos da tag
     *  @param boolean $inline Verdadeiro para imprimir a folha de estilo inline
     *  @param boolean $full Verdadeiro para gerar uma URL completa
     *  @return string Elemento de folha de estilo a ser utilizado
     */
    public function stylesheet($href = "", $attr = array(), $inline = true, $full = false) {
        if (is_array($href)):
            $output = "";
            foreach ($href as $tag):
                $output .= $this->stylesheet($tag, $attr, true, $full) . PHP_EOL;
            endforeach;
        else:
            if (!$this->external($href)):
                $href = Mapper::url("/styles/" . $this->extension($href, "css"), $full);
            endif;
            $attr = array_merge(
                    array(
                "href" => $href,
                "rel" => "stylesheet",
                "type" => "text/css"
                    ), $attr
            );
            $output = $this->output($this->tag("link", null, $attr, true));
        endif;
        if ($inline):
            return $output;
        else:
            $this->view->stylesForLayout .= $output;
            return true;
        endif;
    }

    /**
     *  Cria um elemento de script para ser usado no HTML.
     * 
     *  @param string $src Caminho do script a ser inseido no HTML
     *  @param array $attr Atributos da tag
     *  @param boolean $inline Verdadeiro para imprimir o script inline
     *  @param boolean $full Verdadeiro para gerar uma URL completa
     *  @return string Elemento de script a ser utilizado
     */
    public function script($src = "", $attr = array(), $inline = true, $full = false) {
        if (is_array($src)):
            $output = "";
            foreach ($src as $tag):
                $output .= $this->script($tag, $attr, true, $full) . PHP_EOL;
            endforeach;
        else:
            if (!$this->external($src)):
                $src = Mapper::url("/scripts/" . $this->extension($src, "js"), $full);
            endif;
            $attr = array_merge(
                    array(
                "src" => $src,
                "type" => "text/javascript"
                    ), $attr
            );
            $output = $this->output($this->tag("script", null, $attr));
        endif;
        if ($inline):
            return $output;
        else:
            $this->view->scriptsForLayout .= $output;
            return true;
        endif;
    }

    /*
     *  Cria uma lista a partir de um array.
     *  
     *  @param array $list Array com conjunto de elementos da lista
     *  @return string
     */

    public function nestedList($list, $attr = array(), $type = "ul") {
        $content = "";
        foreach ($list as $k => $li):
            if (is_array($li)):
                $li = $this->nestedList($li, array(), $type);
                if (!is_numeric($k)):
                    $li = $k . $li;
                endif;
            endif;
            $content .= $this->tag("li", $li) . PHP_EOL;
        endforeach;
        return $this->tag($type, $content, $attr);
    }

    /**
     *  Cria uma tag DIV.
     *
     *  @param string $content Conteúdo da tag
     *  @param array $attr Atributos da tag
     *  @return string Tag DIV
     */
    public function div($content, $attr = array()) {
        if (!is_array($attr)):
            $attr = array("class" => $attr);
        endif;
        return $this->output($this->tag("div", $content, $attr));
    }

    /**
     *  Adiciona uma meta tag para definir o charset da página.
     *
     *  @param string $charset Charset a ser utilizado
     *  @return string Tag META
     */
    public function charset($charset = null) {
        if (is_null($charset)):
            $charset = Config::read("appEncoding");
        endif;
        $attr = array(
            "http-equiv" => "Content-type",
            "content" => "text/html; charset={$charset}"
        );
        return $this->output($this->tag("meta", null, $attr));
    }

    /**
     *  Verifica se uma URL é externa.
     *
     *  @param string $url URL a ser verificada
     *  @return boolean Verdadeiro se a URL for externa
     */
    public function external($url) {
        return preg_match("/^[a-z]+:/", $url);
    }

    /**
     *  Adiciona uma extensão a um arquivo caso ela não exista.
     *
     *  @param string $file Nome do arquivo
     *  @param string $extension Extensão a ser adicionada
     *  @return string Novo nome do arquivo
     */
    public function extension($file, $extension) {
        if (strpos($file, "?") === false):
            if (strpos($file, "." . $extension) === false):
                $file .= "." . $extension;
            endif;
        endif;
        return $file;
    }
    /**
     *  Corta um texto e adiciona "..."
     *
     *  @param string $length Tamanho Máximo da String
     *  @param string $complement O que complementará após o corte
     *  @param string $text Texto a ser cortado
     *  @return string Texto cortado e com o complemento informado
     */
    public function slice($length, $complement, $text) {
        if (strlen($text) > $length):
            $text = substr($text, 0, $length);
            $length = strrpos($text, " ");

            return substr($text, 0, $length) . $complement;
        else:
            return $text;
        endif;
    }
    
    /**
     *  Retorna uma mensagem de erro já com os parametros do FORMEE
     *
     *  @param string $type Define o tipo de mensagem
     *  @param string $text Mensagem do Aviso
     *  @return string HTML com mensagem
     */
    public function printWarning($text=null,$type="info"){
        return $this->tag("div",$this->tag("h3",$text),array("class"=>"formee-msg-$type"));
        
    }
    
    public function boxDashboard($title,$content,$classSize){
        $output = $this->openBoxDashboard($title, $content, $classSize);
        $output .= $this->closeBoxDashboard();        
        return $output;
    }
    
    public function openBoxDashboard($title,$content,$classSize){
        $output = $this->openTag("div",array("class"=>$classSize));
        $output .= $this->openTag("div", array("class"=>"caixa"));
        $output .= $this->tag("div",$this->tag("h3",$title),array("class"=>"title"));
        $output .= $this->tag("div",$content,array("class"=>"borda tamanho1"));
        return $output;
    }
    
    public function closeBoxDashboard(){
        $output = $this->closeTag("div");
        $output .= $this->closeTag("div");
        return $output;
    }

    /**
     *  Cria uma lista para formação de Treeview css3 e HTML5
     *
     *  @param array $array Lista da Estrutura
     *  @return string Lista em UL > LI do vetor informado no parametro
     */
    public function array2ul($array,$class=null) {

        foreach ($array as $pais) {
            $output .= $this->tag("ul", is_array($pais["filhos"]) ? $this->tag("li", $pais["nome"] . $this->array2ul($pais["filhos"])) : $this->tag("li", $pais["nome"]),!empty($class)?array("class"=>$class):array());
        }

        return $output;
    }

    public function apiMaps($address, $width = 400, $height = 400) {
        $address = "http://maps.google.com/maps/api/staticmap?center={$address}&zoom=16&size={$width}x{$height}&
markers=size:medium|label:A|color:blue|{$address}&sensor=true";
        return $this->image($address);
    }

}

?>