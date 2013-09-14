function CKUpdate(){
    for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
    }
}

function alert(message,url){
    var id = this.geraID();
    
    $("body").append('<div id=\''+id+'\' title=\'Aviso\'><div id=\'dvCont'+id+'\'><p><span class="ui-icon ui-icon-circle-check" style="float: left; margin: 0 7px 50px 0;"></span>'+message+'</p></div></div>');
    if(url!==undefined){
        loadDiv("#dvCont"+id, url);
    }
    $( "#"+id ).dialog({
        modal: true,
        resizable:false,
        buttons: {
            Ok: function() {
                $( this ).dialog( "close" );
                $( "#"+id ).remove();
            }
        }
    });
}

function deletar(url){
    if(confirm("Deseja realmente deletar esse registro?")){
        window.location=url;
    }
}
//function confirm(question,btnYes, btnNo){
//    if(btnYes == null){
//        btnYes = "Sim";
//    }
//    if(btnNo == null){
//        btnNo = "Não";
//    }
//    var id = this.geraID();
//    $("body").append('<div id=\''+id+'\' title=\'Confirmação\'><div id=\'dvCont'+id+'\'><p><span class="ui-icon ui-icon-circle-check" style="float: left; margin: 0 7px 50px 0;"></span>'+question+'</p></div></div>');
//    $( "#"+id ).dialog({
//      modal: true,
//      resizable:false,
//      buttons: {
//        btnYes: function() {
//          $( this ).dialog( "close" );
//          $( "#"+id ).remove();
//          return true;
//        },
//        Cancel:function(){
//            $( this ).dialog( "close" );
//            $( "#"+id ).remove();
//            return false;
//
//        }
//      }
//    });
//}
function confirma(questao,url){
    if(confirm(questao)){
        window.location=url;
    }
}

function confirmaAjax(questao,url){
    if(confirm(questao)){
        $.get(url);
    }
}

function delAjax(url,idDiv, urlRedirect){
    if(confirm("Deseja realmente deletar esse registro?")){
        $("#"+idDiv).html("<center><img src='/images/load.gif'></center>");
        //$.get(url,function(data){alert(data)});
        $.get(url);
        $('#'+idDiv).load(urlRedirect);
    }
}

function popIn(idJ,url){
    $( "#"+idJ ).dialog('open','width', 500);
    if (url == ''){

    }else{
        $("#"+idJ).html("<center><img src='/images/load.gif'></center>");
        $("#"+idJ).load(url);
    }

}

function criaJanela(id,icone,titulo,pagina,tamH,tamW,modal,botoes,idConversa){
    var parametros = {
        icon: icone,
        icon_draggable: true,
        dock: "#quick-bar",
        dock_sortable: true,
        collapsed: false
    }
    var result = "";

    var div = document.getElementById(id);
    if (div) {
        return false;
    }

    $("body").append('<div id='+id+' title='+titulo+'><div id=dvCont'+id+'></div></div>');

    result = $('#'+id).dialog({
        closeOnEscape: true,
        height: tamH,
        width:tamW,
        modal:modal,
        title:titulo,
        resizable:false,
        maxHeight: screen.availHeight - 170,
        maxWidth: screen.width -50,
        stack: true,
        focus: function() {
        },
        beforeClose: function() {
            $(this).remove();

        },
        buttons: botoes
    });
    $('#dvCont'+id).html("<center><img src='/images/load.gif'></center>");
    $('#dvCont'+id).load(pagina);
    if (modal != true){
    }

    return result;
}



function geraID(){
    var l = "abcdefghijklmnopqrstuvwxyz";
    var n = "0123456789";
    var i, pw, rn, rl = 0;


    for(i=1;i<=4;i++) {
        rn = parseInt(Math.random()*10);
        rl = parseInt(Math.random()*26);

        if(i > 1) {
            pw=pw+l.charAt(rl)+n.charAt(rn);
        } else {
            pw=l.charAt(rl)+n.charAt(rn);
        }
    }
    return "ID"+pw;
}

function AbreJanela(url, width, height, title, idConversa, modal){
    var idJanela = this.geraID();
    //var div = this.geraID();
    if(modal != true){
        modal = false;
    }

    //$("body").append("<div id="+idJanela+"><div id="+idConteudo+"></div></div>");

    var Janela = criaJanela(idJanela,title,title,url,height,width,modal,'',idConversa);
    Janela.dialog('open');

}

function sucessRequisition(obj,type,text){

}

function delDiv(id){
    $("#"+id).remove();
}

function stateLoad(div){
    $(div).html("<center><img src='/images/load.gif'></center>");
}

function loadDiv(div, url){
    $(div).html("<center><img src='/images/load.gif'></center>");
    $(div).load(url);
}

function populaCombo(url, objeto, metodo){
    if(metodo == 'options'){
        $(objeto).load(url);
    }
}

function resetDiv(div){
    $(div).html("<p>&nbsp;</p>");
}

function consultaCep(cep){
    $.getJSON("/integracao/cep/"+cep, function(data){
        return data;
    });
    
    
}

function runHelp(){
    $("#togglerHelp").toggle( "slide", 500 );
}