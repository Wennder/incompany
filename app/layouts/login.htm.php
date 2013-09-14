<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <meta name="language" content="pt-br" />
        <title>Syntex Desktop - *beta</title>
        <?php
        //Scripts
        echo $html->script("jquery");
        echo $html->script("ui/jquery-ui-1.8.5.custom.js");
        //Styles
        echo $html->stylesheet("login");
        echo $html->stylesheet("/themes/flick/jquery.ui.all.css");
        ?>
        <script>
            $(function(){
                $('#avisoSistema').dialog({
                    autoOpen: false,
                    width: 250,
                    height:130,
                    title:"Aviso do Sistema",
                    modal: true,
                    buttons: {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    }
                });
                
                <?php
                $mensagens = Session::flash("Auth.error");
                if (!empty($mensagens)) {
                    echo "$('#avisoSistema').dialog('open');";
                }
                ?>
            });
        </script>
    </head>

    <body>
        <div class="central">
            <div id="login-box">
                <?php
                echo $this->contentForLayout;
                ?>
            </div>
        </div>

        <div id="avisoSistema">
            <?php
            if (!empty($mensagens)) {
                echo "<center>";
                echo $mensagens;
                echo "</center>";
                
            }
            ?>            
        </div>
    </body>
</html>
