<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="language" content="pt-br" />
        <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon" />

        <title>Syntex Tracking Information</title>

        <?php
        echo $html->script("jquery.js");
        echo $html->script("ui/jquery-ui-1.8.5.custom.js");
        echo $html->stylesheet("themes/flick/jquery.ui.all.css");
        echo $html->stylesheet("templateStyle/style.css");
        echo $html->stylesheet("formee/formee-style.css");
        echo $html->stylesheet("formee/formee-structure.css");
        echo $html->stylesheet("/nLayout/submenu.css"); // TEMPORARIO
        ?>
        <script>
            $(function(){
                $("button,.botao, inputsubmit, inputbutton, button", "html").button();
               
        //Colocar para funcionar nem que seja a força        
        $(".caixa>div.title").dblclick(function(){
            $(this).parent().find("div.borda").toggle("blind","1000");
        });
        
            });
        </script>

    </head>

    <body>

        <div id="top">

            <div class="grid_3">
                <a href="http://beta.syntex.com.br"><img src="/images/templateImages/logo-syntex.png" alt="Syntex Tracking Information"></a>
            </div><!-- .grid_3 -->

            <div class="grid_1">
                <a href="/site/logout"><img src="/images/templateImages/bt-sair.png"></a>
            </div><!-- .grid_1 -->

        </div><!-- #top -->

        <div id="menu">

            <?php echo $this->element("/gadgets/nMenu"); ?><!-- .menu -->

        </div><!-- #menu -->
        <div class="iconesMenu">
            <?php
            $here = $this->params;
            $here = explode("/", $here["here"]);
            $nomeComponente = $here[1] . ucwords($here[2]);

            if (file_exists(APP . DS . "views/submenus/_$nomeComponente.htm.php")) {
                echo $this->element("/submenus/$nomeComponente", array("op" => $here[3]));
            }
            ?>
        </div>
        <div id="main" class="container_16"> 
            <?php
            echo $this->contentForLayout;
            ?> 

        </div><!-- #main -->

        <div id="footer">

            <div class="bt_footer">
                <a class="bt" href="">Dúvidas de como usar a <strong>Aplicação</strong>?</a>
            </div><!-- .bt_footer -->

            <div class="grid_6">
                <h3>Empresa</h3>
                <form action="" class="" id="" method="">
                    <select name="empresa">
                        <option value="Syntex">Syntex</option>
                    </select>
                </form>
                <div class="nome">
                    <?php
                    echo $html->tag("h3",$loggedUser["nome"]);
                    echo $html->tag("h4",$loggedUser["cargo"]);
                    ?>
                </div><!-- .nome -->
                <div class="empresa">
                    <?php
                    echo $html->tag("h3","Empresa");
                    echo $html->tag("h4",$loggedUser["empresa"]["nomeFantasia"]);
                    ?>
                </div><!-- .empresa -->
            </div><!-- .grid_6 -->

            <div class="grid_5">
                <h4>Informações gerais do sistema</h4>
                <p>180 pessoas cadastradas</p>
                <p>1500 usuários ativos</p>
                <p>4000 ações realizadas</p>
            </div><!-- .grid_5 -->

            <div class="grid_5">
                <h4>Informações da empresa</h4>
                <p>150 Contratados cadastrados</p>
                <p>200 Novas propostas</p>
                <p>2000 Clientes cadastrados</p>
            </div><!-- .grid_5 -->

            <div class="footer">
                <p>© 2013 Syntex Assessoria e Consultoria em Negócios LTDA</p>
            </div><!-- .footer -->

            <div class="footer2">
                <p>Última Alteração: 01/01/2013 17:00:00 - por: Robson Miranda</p>
            </div><!-- .footer2 -->

        </div><!-- #footer -->

    </body>
</html>