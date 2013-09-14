<?php
echo $html->script("/jquery.nivo.slider.pack.js");
echo $html->stylesheet("/nivo/nivo/nivo-slider.css");
echo $html->stylesheet("/nivo/nivo/default/default.css");
//echo $html->stylesheet("/nivo/nivo/orman/orman.css");
//echo $html->stylesheet("/nivo/nivo/pascal/pascal.css");
?>
<div class="slider-wrapper theme-default">
    <div class="ribbon"></div>
    <div id="slider" class="nivoSlider">
        <img src="/images/marketing/sliderHome/01.jpg" alt="" />
        <img src="/images/marketing/sliderHome/02.jpg" alt="" />
        <img src="/images/marketing/sliderHome/03.jpg" alt="" />
        <img src="/images/marketing/sliderHome/04.jpg" alt="" />        
    </div>
</div>

<script type="text/javascript">
    $(window).load(function() {
        
        $("a.linkAcessoRapido").append("<div style='margin-top:-20px; text-align:center;'>"+$(this).children("img").attr("alt")+"</div>");
        
        $('#slider').nivoSlider({
            effect:"fold",
            boxCols:8,
            boxRows:4,
            animSpeed:500,
            pauseTime:4000,
            startSlide:0,
            directionNav:true,
            directionNavHide:true,
            controlNav:true,
            controlNavThumbs:false,
            controlNavThumbsFromRel:true,
            keyboardNav:true,
            pauseOnHover:true,
            manualAdvance:false
        });
    });
</script>
<?php
echo $html->openTag("div", array("class" => "boxLinksRapidos"));
echo $html->imageLink("/nLayout/btn_ajuda_online.jpg","javascript:void(0);",array("border"=>"0","alt"=>"Acesso"),array("onclick"=>"window.open('http://na.ntrsupport.com/nv/inquiero/anonymous2.asp?skclient=&lang=br&con=1&online=1&bonline=1&video=&hdcli=&usrrand=1410401000222378132&login=22237&surpre=&sur=&oper=&cat=&cob=0&txtcolor=&bgcolor=&buttoncolor=&ref=&ref2=&tframe=&hd=&hduser=&URLOffline=&URLbusy=&TransferMsg=1&t=&k=','Ajuda online Assistec','width=600, height=600, scrollbars=no, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');","style"=>"float:left;","class"=>"linkAcessoRapido"));
echo $html->imageLink("/nLayout/btn_chamados.jpg","http://www.assistecinformatica.com.br/sgo/",array("border"=>"0"),array("alt"=>"Abertura de Chamados","style"=>"float:left; margin-left:10px;","class"=>"linkAcessoRapido"));
echo $html->imageLink("/nLayout/btn_email.jpg","http://www.assistecinformatica.com.br/uebi/",array("border"=>"0"),array("target"=>"_blank","alt"=>"Email","style"=>"float:left; margin-left:10px;","class"=>"linkAcessoRapido"));

echo "<br clear='all'/>";
echo "<br clear='all'/>";

echo $html->openTag("div");
echo $html->imageLink("/nLayout/trabalheConosco.jpg","/site/pagina/");
echo $html->closeTag("div");
?>


    <?php
    echo $html->closeTag("div");
    

    //echo $this->element("/gadgets/newsInfo");
    ?>