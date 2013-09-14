$(document).ready(function() {

    var $calendar = $('#agenda');
    //Cria e destroe a janela de inserção de compromisso
    $("#editarCompromisso").hide();
    
    $calendar.weekCalendar({
        timeslotsPerHour : 2,
        allowCalEventOverlap : true,
        overlapEventsSeparate: true,
        firstDayOfWeek : 0,
        businessHours :{
            start: 8,
            end: 18,
            limitDisplay: false
        },
        daysToShow : 7,
        height : function() {
            return 380;
        },
        eventRender : function(calEvent, $event) {
            if (calEvent.end.getTime() < new Date().getTime()) {
                $event.css("backgroundColor", "#aaa");
                $event.find(".wc-time").css({
                    "backgroundColor" : "#999",
                    "border" : "1px solid #888"
                });
            }
        },
        draggable : function(calEvent, $event) {
            return calEvent.readOnly != true;
        },
        resizable : function(calEvent, $event) {
            return calEvent.readOnly != true;
        },
        eventNew : function(calEvent, $event) {
            var $dialogContent = $("#editarCompromisso");
            resetForm($dialogContent);
            var startField = $dialogContent.find("select[name='inicio']").val(calEvent.start);
            var endField = $dialogContent.find("select[name='termino']").val(calEvent.end);
            var titleField = $dialogContent.find("input[name='titulo']");
            var bodyField = $("#FormObservacao");
            var donoField = $("#donoAgenda").val();


            $dialogContent.dialog({
                modal: true,
                width: 500,
                title: "Novo Compromisso",
                close: function() {
                    $dialogContent.dialog("destroy");
                    $dialogContent.hide();
                    $calendar.weekCalendar("removeUnsavedEvents");
                },
                buttons: {
                    salvar : function() {
                        calEvent.start = new Date(startField.val());
                        calEvent.end = new Date(endField.val());
                        calEvent.title = titleField.val();
                        calEvent.body = bodyField.val();

                        var dStart = calEvent.start;
                        var dtStart = new Date(dStart);
                        var sqlDateStart = dtStart.getFullYear() + "-" + (dtStart.getMonth()+1) + "-" + dtStart.getDate() + " " + dtStart.getHours() + ":" + dtStart.getMinutes();

                        var dEnd = calEvent.end;
                        var dtEnd = new Date(dEnd);
                        var sqlDateEnd = dtEnd.getFullYear() + "-" + (dtEnd.getMonth()+1) + "-" + dtEnd.getDate() + " " + dtEnd.getHours() + ":" + dtEnd.getMinutes();

                        $.post("/agenda/compromissos/cadastrar", {
                            funcionario_id: donoField,
                            titulo: titleField.val(),
                            observacao : bodyField.val(),
                            inicio: sqlDateStart,
                            termino: sqlDateEnd
                        },
                        function(data) {
                            calEvent.id = data; //Coloca o ID de acordo com o banco de dados
                            $calendar.weekCalendar("removeUnsavedEvents");
                            $calendar.weekCalendar("updateEvent", calEvent);//Poe os dados no json, e o coloca no calendário.
                        });
                        $dialogContent.dialog("destroy");
                    },
                    cancelar : function() {
                        $dialogContent.dialog("destroy");
                    }
                }
            }).show();

            $dialogContent.find(".date_holder").text($calendar.weekCalendar("formatDate", calEvent.start));
            setupStartAndEndTimeFields(startField, endField, calEvent, $calendar.weekCalendar("getTimeslotTimes", calEvent.start));

        },
        eventDrop : function(calEvent, $event) {
            var dStart = calEvent.start;
            var dtStart = new Date(dStart);
            var sqlDateStart = dtStart.getFullYear() + "-" + (dtStart.getMonth()+1) + "-" + dtStart.getDate() + " " + dtStart.getHours() + ":" + dtStart.getMinutes();

            var dEnd = calEvent.end;
            var dtEnd = new Date(dEnd);
            var sqlDateEnd = dtEnd.getFullYear() + "-" + (dtEnd.getMonth()+1) + "-" + dtEnd.getDate() + " " + dtEnd.getHours() + ":" + dtEnd.getMinutes();
                        
            $.post("/agenda/compromissos/editar/"+calEvent.id, {
                id:calEvent.id,                
                inicio: sqlDateStart,
                termino: sqlDateEnd
            });
        },
        eventResize : function(calEvent, $event) {
            var dStart = calEvent.start;
            var dtStart = new Date(dStart);
            var sqlDateStart = dtStart.getFullYear() + "-" + (dtStart.getMonth()+1) + "-" + dtStart.getDate() + " " + dtStart.getHours() + ":" + dtStart.getMinutes();

            var dEnd = calEvent.end;
            var dtEnd = new Date(dEnd);
            var sqlDateEnd = dtEnd.getFullYear() + "-" + (dtEnd.getMonth()+1) + "-" + dtEnd.getDate() + " " + dtEnd.getHours() + ":" + dtEnd.getMinutes();

            $.post("/agenda/compromissos/editar/"+calEvent.id, {
                id:calEvent.id,
                inicio: sqlDateStart,
                termino: sqlDateEnd
            });
        },
        eventClick : function(calEvent, $event) {

            if (calEvent.readOnly) {
                return;
            }

            var $dialogContent = $("#editarCompromisso");
            resetForm($dialogContent);
            var startField = $dialogContent.find("select[name='inicio']").val(calEvent.start);
            var endField = $dialogContent.find("select[name='termino']").val(calEvent.end);
            var titleField = $dialogContent.find("input[name='titulo']").val(calEvent.title);
            var bodyField = $("#FormObservacao");
            $("#FormObservacao").attr("value", calEvent.body);

            $dialogContent.dialog({
                modal: true,
                width:500,
                title: "Editar - " + calEvent.title,
                close: function() {
                    $dialogContent.dialog("destroy");
                    $dialogContent.hide();
                    $calendar.weekCalendar("removeUnsavedEvents");
                },
                buttons: {
                    salvar : function() {

                        calEvent.start = new Date(startField.val());
                        calEvent.end = new Date(endField.val());
                        calEvent.title = titleField.val();
                        calEvent.body = bodyField.val();

                        var dStart = calEvent.start;
                        var dtStart = new Date(dStart);
                        var sqlDateStart = dtStart.getFullYear() + "-" + (dtStart.getMonth()+1) + "-" + dtStart.getDate() + " " + dtStart.getHours() + ":" + dtStart.getMinutes();

                        var dEnd = calEvent.end;
                        var dtEnd = new Date(dEnd);
                        var sqlDateEnd = dtEnd.getFullYear() + "-" + (dtEnd.getMonth()+1) + "-" + dtEnd.getDate() + " " + dtEnd.getHours() + ":" + dtEnd.getMinutes();

                        $.post("/agenda/compromissos/editar/"+calEvent.id, {
                            id:calEvent.id,
                            titulo: calEvent.title,
                            observacao: calEvent.body,
                            inicio: sqlDateStart,
                            termino: sqlDateEnd
                        },
                        function(data){
                            $calendar.weekCalendar("updateEvent", calEvent);
                            $dialogContent.dialog("destroy");
                        });

                        
                    },
                    "Deletar" : function() {
                        if (confirm("Deseja deletar o compromisso: \""+calEvent.title+"\"?")){
                            $.get("/agenda/compromissos/deletar/"+calEvent.id);
                            $calendar.weekCalendar("removeEvent", calEvent.id);
                            $dialogContent.dialog("destroy");
                        }else{
                            $dialogContent.dialog("destroy");
                        }

                    },
                    cancelar : function() {
                        $dialogContent.dialog("destroy");
                    }
                }
            }).show();

            var startField = $dialogContent.find("select[name='inicio']").val(calEvent.start);
            var endField = $dialogContent.find("select[name='termino']").val(calEvent.end);
            $dialogContent.find(".date_holder").text($calendar.weekCalendar("formatDate", calEvent.start));
            setupStartAndEndTimeFields(startField, endField, calEvent, $calendar.weekCalendar("getTimeslotTimes", calEvent.start));
            $(window).resize().resize(); //fixes a bug in modal overlay size ??

        },
        eventMouseover : function(calEvent, $event) {
        },
        eventMouseout : function(calEvent, $event) {
        },
        noEvents : function() {

        },
        data : "/agenda/jsonAgenda/"
    });

    function resetForm($dialogContent) {
        $dialogContent.find("input").val("");
        $dialogContent.find("textarea").val("");
    }

    


    /*
    * Sets up the start and end time fields in the calendar event
    * form for editing based on the calendar event being edited
    */
    function setupStartAndEndTimeFields($startTimeField, $endTimeField, calEvent, timeslotTimes) {

        for (var i = 0; i < timeslotTimes.length; i++) {
            var startTime = timeslotTimes[i].start;
            var endTime = timeslotTimes[i].end;
            var startSelected = "";
            if (startTime.getTime() === calEvent.start.getTime()) {
                startSelected = "selected=\"selected\"";
            }
            var endSelected = "";
            if (endTime.getTime() === calEvent.end.getTime()) {
                endSelected = "selected=\"selected\"";
            }
            $startTimeField.append("<option value=\"" + startTime + "\" " + startSelected + ">" + timeslotTimes[i].startFormatted + "</option>");
            $endTimeField.append("<option value=\"" + endTime + "\" " + endSelected + ">" + timeslotTimes[i].endFormatted + "</option>");

        }
        $endTimeOptions = $endTimeField.find("option");
        $startTimeField.trigger("change");
    }

    var $endTimeField = $("select[name='end']");
    var $endTimeOptions = $endTimeField.find("option");

    //reduces the end time options to be only after the start time options.
    $("select[name='start']").change(function() {
        var startTime = $(this).find(":selected").val();
        var currentEndTime = $endTimeField.find("option:selected").val();
        $endTimeField.html(
            $endTimeOptions.filter(function() {
                return startTime < $(this).val();
            })
            );

        var endTimeSelected = false;
        $endTimeField.find("option").each(function() {
            if ($(this).val() === currentEndTime) {
                $(this).attr("selected", "selected");
                endTimeSelected = true;
                return false;
            }
        });

        if (!endTimeSelected) {
            //automatically select an end date 2 slots away.
            $endTimeField.find("option:eq(1)").attr("selected", "selected");
        }

    });

    //adiciona o evento de extender o tamanho do calendário.
    $(".toogle").click(function(){
        var valor = $(".toogle").html();
        if(valor=="Extender"){            
            $(".menu_esq").fadeOut(1000,function(){
                $("#center").css("width", "100%");
                $(".toogle").html("Diminuir");
            });
        }else{
            $("#center").css("width", "80%");
            $(".menu_esq").fadeIn(1000, function(){
               $(".toogle").html("Extender");
            });
            
        }
        
    });

    $("#selAgenda").load("/agenda/selectFuncionarios/");
});