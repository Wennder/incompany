var processo = $("#idProcesso").val();
var fobProcesso;
var cifProcesso = 0;

function updateDespesasNacionalizacao(){
    var processo = $("#idProcesso").val();
    $("#qtdItens").load("/importacoes/despesasNacionalizacao/count/"+processo);
    $("#somaItens").load("/importacoes/despesasNacionalizacao/somaTotal/"+processo);
}
function recalculaProcesso(processo){
    $('#formProcesso').ajaxSubmit(function(){
        d= new Date();
        hora = d.getHours();
        minuto = d.getMinutes();
        if(minuto < 10){
            minuto = "0"+minuto;
        }
        $("#ultimoSave").html("Salvo às "+hora+":"+minuto); 
        $( "#ultimoSave" ).effect("pulsate", 500 );
        alert('','/importacoes/recalculaProcesso/'+processo);
    });
    
}

function calculaCif(){
    var fob = parseFloat($("#FormFob").val());
    var frete = parseFloat($("#FormFrete").val());
    var seguro = parseFloat($("#FormSeguro").val());
    var thc = parseFloat($("#FormThc").val());
    cif = fob+frete+seguro+thc;
    $("#valorCif").val(cif.toFixed(2));
}

function lockTornarPedido(){
    $("#linkTornaPedido").attr("href","javascript:void(0);");
    $("#linkTornaPedido").attr("onClick","alert('Este processo já é um pedido!');");
}

$("#salvaProcesso").click(function(){
    $('#formProcesso').ajaxSubmit(function() { 
        d= new Date();
        hora = d.getHours();
        minuto = d.getMinutes();
        if(minuto < 10){
            minuto = "0"+minuto;
        }
        $("#ultimoSave").html("Salvo às "+hora+":"+minuto); 
        $( "#ultimoSave" ).effect("pulsate", 500 );
    }); 
});
    
$(document).ready(function() {
    //Executa as abas do processo
    $("#abaProcesso").tabs();
    //$("#abaMemorial").tabs(); 
    //Busca cidades, estado e pais do mundo todo
    $("#FormOrigem, #FormDestino").autocomplete({
        source: function(request, response){
            $.ajax({
                url: "http://ws.geonames.org/searchJSON",
                dataType : "jsonp",
                data: {
                    featureClass: "P",
                    style: "full",
                    maxRows: 4,
                    name_startsWith: request.term
                },
                success: function( data ){
                    response( $.map( data.geonames, function (item){
                        return {
                            label: item.name + (item.adminName1 ? ", " + item.adminName1 : "") + ", " + item.countryName,
                            value: item.name + (item.adminName1 ? ", " + item.adminName1 : "") + ", " + item.countryName
                        }
                    }));
                }
            });
        },
        minLength: 2
    });
    
    $("#FormNomecliente").autocomplete({
        source: "/integracao/autocomplete/comercial_clientes/nomeFantasia/",
        minLength: 3,
        select: function(event, ui){
            $("#FormClienteId").val(ui.item.id);
            $("#FormContatoId").load("/integracao/options/comercial_contatos/nome/0/id_cliente/"+ui.item.id+"/");
        }
    });
    
    $("#FormTipoembarque").change(function(){
        $("#FormAgentecarga").load("/integracao/agenteCarga/"+$("#FormTipoembarque").val());
    });
    
});
